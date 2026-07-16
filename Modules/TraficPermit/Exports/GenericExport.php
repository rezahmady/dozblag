<?php

namespace Modules\TraficPermit\Exports;

use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;

class GenericExport implements FromCollection, WithMapping, WithHeadings, ShouldQueue
{
    use Exportable;
    protected $crud;

    public function __construct(CrudPanel $crud)
    {
        $this->crud = $crud;
    }

    public function collection()
    {
        return $this->crud->getEntries();
    }

    public function map($row): array
    {

        $htmlValue = $this->crud->getRowViews($row, false);

        foreach ($htmlValue as $key => $column_value) {
            $plainTextValue = strip_tags($column_value);

            $cleanValue = str_replace(["\r\n", "\r", "\n"], ' ', $plainTextValue);
            $cleanValue = trim($cleanValue);
            $htmlValue[$key] = $cleanValue;
        }

        return $htmlValue;

    }

    public function headings(): array
    {
        return array_values(array_map(function($column) {
            return $column['label'];
        }, $this->crud->columns()));
    }
}
