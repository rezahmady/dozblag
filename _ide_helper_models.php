<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Article
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property string|null $image
 * @property string $status
 * @property bool $featured
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property object|null $extras
 * @property int $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $allComments
 * @property-read int|null $all_comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @property mixed $dislike
 * @property mixed $like
 * @property-read mixed $slug_or_title
 * @property mixed $telegram
 * @property mixed $whatsapp
 * @property-read mixed $whatsapp_content
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Page[] $pages
 * @property-read int|null $pages_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Article findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Article published()
 * @method static \Illuminate\Database\Eloquent\Builder|Article query()
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereExtras($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article withUniqueSlugConstraints(\Illuminate\Database\Eloquent\Model $model, string $attribute, array $config, string $slug)
 */
	class Article extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Category
 *
 * @property int $id
 * @property int|null $parent_id
 * @property int|null $lft
 * @property int|null $rgt
 * @property int|null $depth
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Article[] $articles
 * @property-read int|null $articles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Category[] $children
 * @property-read int|null $children_count
 * @property-read mixed $slug_or_name
 * @property-read Category|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder|Category findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Category firstLevelItems()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDepth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereLft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereRgt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category withUniqueSlugConstraints(\Illuminate\Database\Eloquent\Model $model, string $attribute, array $config, string $slug)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Chat
 *
 * @property int $id
 * @property int $user_id
 * @property int $room_id
 * @property string $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $parent_id
 * @property string|null $seen
 * @property string|null $type
 * @property-read mixed $date
 * @property-read mixed $date_full
 * @property-read mixed $time
 * @property-read Chat|null $parent
 * @property-read \App\Models\Room $room
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Chat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Chat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Chat query()
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereSeen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereUserId($value)
 */
	class Chat extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Comment
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $module
 * @property int $module_id
 * @property string|null $name
 * @property string|null $email
 * @property int|null $parent_id
 * @property string|null $body
 * @property string|null $score
 * @property string|null $status
 * @property object|null $extras
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Comment[] $children
 * @property-read int|null $children_count
 * @property-read Comment|null $parent
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereExtras($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereModule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereModuleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUserId($value)
 */
	class Comment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Filter
 *
 * @property int $id
 * @property string $name
 * @property int|null $parent_id
 * @property int|null $lft
 * @property int|null $rgt
 * @property int|null $depth
 * @property int $status
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $module
 * @property-read \Illuminate\Database\Eloquent\Collection|Filter[] $children
 * @property-read int|null $children_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FilterItem[] $items
 * @property-read int|null $items_count
 * @property-read Filter|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder|Filter firstLevelItems()
 * @method static \Illuminate\Database\Eloquent\Builder|Filter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Filter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Filter query()
 * @method static \Illuminate\Database\Eloquent\Builder|Filter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Filter whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Filter whereDepth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Filter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Filter whereLft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Filter whereModule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Filter whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Filter whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Filter whereRgt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Filter whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Filter whereUpdatedAt($value)
 */
	class Filter extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FilterItem
 *
 * @property int $id
 * @property int $filter_id
 * @property string $name
 * @property int|null $parent_id
 * @property int|null $lft
 * @property int|null $rgt
 * @property int|null $depth
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $image
 * @property-read \Illuminate\Database\Eloquent\Collection|FilterItem[] $children
 * @property-read int|null $children_count
 * @property-read \App\Models\Filter $filter
 * @property-read \App\Models\Filter $filterModule
 * @property-read FilterItem|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder|FilterItem field($id)
 * @method static \Illuminate\Database\Eloquent\Builder|FilterItem firstLevelItems()
 * @method static \Illuminate\Database\Eloquent\Builder|FilterItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FilterItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FilterItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|FilterItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilterItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilterItem whereDepth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilterItem whereFilterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilterItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilterItem whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilterItem whereLft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilterItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilterItem whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilterItem whereRgt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilterItem whereUpdatedAt($value)
 */
	class FilterItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Message
 *
 * @property int $id
 * @property string|null $subject
 * @property string|null $content
 * @property string|null $type
 * @property int|null $form_id
 * @property int|null $user_id
 * @property string $status
 * @property array|null $extras
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $from
 * @property int|null $to
 * @property-read \App\Models\Page|null $form
 * @method static \Illuminate\Database\Eloquent\Builder|Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Message query()
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereExtras($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereFormId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereUserId($value)
 */
	class Message extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Ostan
 *
 * @property int $id
 * @property string $name
 * @property string|null $amar_code
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Shahrestan[] $shahrestans
 * @property-read int|null $shahrestans_count
 * @method static \Illuminate\Database\Eloquent\Builder|Ostan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ostan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ostan query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ostan whereAmarCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ostan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ostan whereName($value)
 */
	class Ostan extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Page
 *
 * @property int $id
 * @property string $template
 * @property string $name
 * @property string $title
 * @property string $slug
 * @property string|null $content
 * @property array|null $extras
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $parent_id
 * @property int|null $lft
 * @property int|null $rgt
 * @property int|null $depth
 * @property-read \Illuminate\Database\Eloquent\Collection|Page[] $children
 * @property-read int|null $children_count
 * @property-read mixed $path
 * @property-read mixed $slug_or_title
 * @property-read Page|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder|Page blogTemplate()
 * @method static \Illuminate\Database\Eloquent\Builder|Page findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Page formTemplate()
 * @method static \Illuminate\Database\Eloquent\Builder|Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page query()
 * @method static \Illuminate\Database\Eloquent\Builder|Page shopTemplate()
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereDepth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereExtras($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereLft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereRgt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page withUniqueSlugConstraints(\Illuminate\Database\Eloquent\Model $model, string $attribute, array $config, string $slug)
 */
	class Page extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Permission
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $display_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 */
	class Permission extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $caption
 * @property string|null $description
 * @property string|null $content
 * @property object|null $parameters
 * @property object|null $metas
 * @property object|null $gallery
 * @property object|null $settings
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property object|null $filters
 * @property string|null $image
 * @property object|null $extras
 * @property string|null $template
 * @property-read \App\Models\FilterItem $filter
 * @property-read mixed $date
 * @property-read mixed $limit_caption
 * @property-read mixed $limit_name
 * @property-read mixed $slug_or_name
 * @property-read mixed $status
 * @property-read mixed $thumb
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Page[] $pages
 * @property-read int|null $pages_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Venturecraft\Revisionable\Revision[] $revisionHistory
 * @property-read int|null $revision_history_count
 * @method static \Illuminate\Database\Eloquent\Builder|Product findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product published()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product search($keyword)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCaption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereExtras($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereFilters($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereGallery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMetas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereParameters($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product withUniqueSlugConstraints(\Illuminate\Database\Eloquent\Model $model, string $attribute, array $config, string $slug)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Resource
 *
 * @property int $id
 * @property string $name
 * @property string|null $caption
 * @property string $template
 * @property object|null $extras
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Shahrestan $Shahrestan
 * @property-read mixed $limit_caption
 * @property-read mixed $limit_name
 * @property-read \App\Models\Ostan $ostan
 * @method static \Illuminate\Database\Eloquent\Builder|Resource newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Resource newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Resource query()
 * @method static \Illuminate\Database\Eloquent\Builder|Resource whereCaption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resource whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resource whereExtras($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resource whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resource whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resource whereTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resource whereUpdatedAt($value)
 */
	class Resource extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Room
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $doctor_id
 * @property int|null $operator_id
 * @property object|null $extras
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $doctor
 * @property mixed $status
 * @property-read \App\Models\Chat|null $latestMessage
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Chat[] $messages
 * @property-read int|null $messages_count
 * @property-read \App\Models\User|null $operator
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Room newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Room newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Room query()
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereExtras($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereUserId($value)
 */
	class Room extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Setting
 *
 * @property int $id
 * @property string $key
 * @property string $name
 * @property string|null $description
 * @property string|null $value
 * @property string $field
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereField($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereValue($value)
 */
	class Setting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SettingOperation
 *
 * @property int $id
 * @property string $key
 * @property object|null $fields
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SettingOperation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SettingOperation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SettingOperation query()
 * @method static \Illuminate\Database\Eloquent\Builder|SettingOperation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SettingOperation whereFields($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SettingOperation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SettingOperation whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SettingOperation whereUpdatedAt($value)
 */
	class SettingOperation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Shahrestan
 *
 * @property int $id
 * @property string $name
 * @property int $ostan_id
 * @property string|null $amar_code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ostan $ostan
 * @method static \Illuminate\Database\Eloquent\Builder|Shahrestan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shahrestan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shahrestan query()
 * @method static \Illuminate\Database\Eloquent\Builder|Shahrestan whereAmarCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shahrestan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shahrestan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shahrestan whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shahrestan whereOstanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shahrestan whereUpdatedAt($value)
 */
	class Shahrestan extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Tag
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Article[] $articles
 * @property-read int|null $articles_count
 * @property-read mixed $slug_or_name
 * @method static \Illuminate\Database\Eloquent\Builder|Tag findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag withUniqueSlugConstraints(\Illuminate\Database\Eloquent\Model $model, string $attribute, array $config, string $slug)
 */
	class Tag extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Theme
 *
 * @property int $id
 * @property string $name
 * @property string $folder
 * @property int $active
 * @property string $version
 * @property array|null $extras
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $update
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Widget[] $widgets
 * @property-read int|null $widgets_count
 * @method static \Illuminate\Database\Eloquent\Builder|Theme active()
 * @method static \Illuminate\Database\Eloquent\Builder|Theme newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Theme newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Theme query()
 * @method static \Illuminate\Database\Eloquent\Builder|Theme whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Theme whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Theme whereExtras($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Theme whereFolder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Theme whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Theme whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Theme whereUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Theme whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Theme whereVersion($value)
 */
	class Theme extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $mobile
 * @property string|null $template
 * @property object|null $extras
 * @property-read mixed $profile
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Chat[] $messages
 * @property-read int|null $messages_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read User $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Room[] $rooms
 * @property-read int|null $rooms_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereExtras($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Widget
 *
 * @property int $id
 * @property string $name
 * @property string|null $prefix
 * @property string|null $label
 * @property string|null $type
 * @property string|null $cat
 * @property string|null $description
 * @property int $theme_id
 * @property string $status
 * @property array|null $extras
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Widget $relationBelongsTo
 * @property-read \Illuminate\Database\Eloquent\Collection|Widget[] $relationHasMany
 * @property-read int|null $relation_has_many_count
 * @property-read \App\Models\Theme $theme
 * @method static \Illuminate\Database\Eloquent\Builder|Widget newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Widget newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Widget query()
 * @method static \Illuminate\Database\Eloquent\Builder|Widget whereCat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Widget whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Widget whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Widget whereExtras($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Widget whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Widget whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Widget whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Widget wherePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Widget whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Widget whereThemeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Widget whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Widget whereUpdatedAt($value)
 */
	class Widget extends \Eloquent {}
}

