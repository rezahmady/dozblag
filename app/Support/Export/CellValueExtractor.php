<?php

namespace App\Support\Export;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Class CellValueExtractor
 *
 * Extracts a plain-text value from a Backpack column definition for an
 * Eloquent model row. This is the "display" value the user would see in
 * the list view, with HTML stripped so it is safe to write into XLSX.
 *
 * Supported column types (most common Backpack types):
 *  - text / default       : direct attribute value
 *  - model_function       : call a method on the model (with optional params)
 *  - select_from_array    : map raw value through an options array
 *  - select / select2     : show related model's identifiable attribute
 *  - select_multiple / select2_multiple / relationship :
 *                           join related models' attributes
 *  - date / datetime      : format directly
 *  - boolean / check      : Yes/No
 *  - closure              : invoke a callable column value
 *
 * For any unknown type, we fall back to the attribute value on the model.
 */
class CellValueExtractor
{
    /**
     * Extract a sanitized string value for a given column definition.
     */
    public static function extract(Model $entry, array $column): string
    {
        $raw = self::resolveRaw($entry, $column);

        // Apply prefix / suffix if Backpack column has them
        $prefix = $column['prefix'] ?? '';
        $suffix = $column['suffix'] ?? '';

        $value = $prefix . $raw . $suffix;

        return self::sanitize($value);
    }

    /**
     * Resolve the raw (pre-sanitization) value for a column.
     */
    protected static function resolveRaw(Model $entry, array $column)
    {
        $type = $column['type'] ?? 'text';
        $name = $column['name'] ?? null;

        // 1) Closure-style column 'value'
        if (isset($column['value']) && is_callable($column['value'])) {
            try {
                return $column['value']($entry, $column);
            } catch (\Throwable $e) {
                return '';
            }
        }

        switch ($type) {
            case 'model_function':
                return self::callModelFunction($entry, $column);

            case 'select_from_array':
                $raw = $name ? data_get($entry, $name) : null;
                $options = $column['options'] ?? [];
                if (is_array($raw)) {
                    return implode(' | ', array_map(
                        fn ($v) => $options[$v] ?? $v,
                        $raw
                    ));
                }
                return $options[$raw] ?? (string) $raw;

            case 'select':
            case 'select2':
                return self::resolveRelationAttribute($entry, $column);

            case 'select_multiple':
            case 'select2_multiple':
            case 'relationship':
                return self::resolveMultipleRelationAttribute($entry, $column);

            case 'date':
                $val = $name ? data_get($entry, $name) : null;
                return $val ? (string) $val : '';

            case 'datetime':
                $val = $name ? data_get($entry, $name) : null;
                return $val ? (string) $val : '';

            case 'boolean':
            case 'check':
                $val = $name ? data_get($entry, $name) : null;
                return $val ? 'بله' : 'خیر';

            case 'number':
                $val = $name ? data_get($entry, $name) : null;
                $decimals = $column['decimals'] ?? 0;
                $decSep   = $column['dec_point'] ?? '.';
                $thouSep  = $column['thousands_sep'] ?? ',';
                return is_numeric($val)
                    ? number_format((float) $val, $decimals, $decSep, $thouSep)
                    : (string) $val;

            case 'text':
            case 'email':
            case 'phone':
            default:
                if ($name && self::hasAttributeOrRelation($entry, $name)) {
                    $val = data_get($entry, $name);
                    if (is_array($val)) {
                        return implode(' | ', array_map('strval', $val));
                    }
                    return (string) ($val ?? '');
                }
                return '';
        }
    }

    /**
     * Call a method on the model and stringify its result.
     *
     * Some Backpack model functions echo HTML directly and return a space.
     * We capture that output buffer to get the actual displayed content.
     */
    protected static function callModelFunction(Model $entry, array $column): string
    {
        $function = $column['function_name'] ?? null;
        if (!$function || !method_exists($entry, $function)) {
            return '';
        }

        $params = $column['function_parameters'] ?? [];
        if (!is_array($params)) {
            $params = [$params];
        }

        try {
            ob_start();
            $returned = $entry->{$function}(...$params);
            $echoed   = ob_get_clean();

            // If the method echoed HTML (common Backpack pattern), use that.
            // Otherwise use the returned value.
            $value = trim((string) $echoed) !== '' && trim((string) $echoed) !== ' '
                ? $echoed
                : $returned;

            if (is_array($value) || is_object($value)) {
                return '';
            }

            return (string) ($value ?? '');
        } catch (\Throwable $e) {
            if (ob_get_level() > 0) {
                ob_end_clean();
            }
            return '';
        }
    }

    /**
     * Resolve a single related model's display attribute.
     */
    protected static function resolveRelationAttribute(Model $entry, array $column): string
    {
        $entity    = $column['entity'] ?? $column['name'] ?? null;
        $attribute = $column['attribute'] ?? 'name';

        if (!$entity) {
            return '';
        }

        $related = data_get($entry, $entity);
        if (!$related) {
            return '';
        }

        return (string) (data_get($related, $attribute) ?? '');
    }

    /**
     * Resolve a many-relation display attribute, joined by ' | '.
     */
    protected static function resolveMultipleRelationAttribute(Model $entry, array $column): string
    {
        $entity    = $column['entity'] ?? $column['name'] ?? null;
        $attribute = $column['attribute'] ?? 'name';

        if (!$entity) {
            return '';
        }

        $related = data_get($entry, $entity);
        if (!$related) {
            return '';
        }

        if (is_iterable($related)) {
            $values = [];
            foreach ($related as $item) {
                $values[] = (string) (data_get($item, $attribute) ?? '');
            }
            return implode(' | ', array_filter($values, fn ($v) => $v !== ''));
        }

        return (string) (data_get($related, $attribute) ?? '');
    }

    /**
     * Check whether the model has an attribute or relation we can pull.
     */
    protected static function hasAttributeOrRelation(Model $entry, string $name): bool
    {
        if (Arr::has($entry->getAttributes(), $name)) {
            return true;
        }
        if (method_exists($entry, $name)) {
            return true;
        }
        // Allow dot-notation paths (e.g. 'repository.country.fa_name')
        return str_contains($name, '.');
    }

    /**
     * Strip HTML, decode entities, collapse whitespace.
     */
    protected static function sanitize(string $value): string
    {
        // Decode HTML entities first so &nbsp; etc. become real chars
        $value = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // Strip all HTML tags
        $value = strip_tags($value);

        // Collapse multiple whitespace (including newlines) into single space
        $value = preg_replace('/\s+/u', ' ', $value);

        return trim((string) $value);
    }
}
