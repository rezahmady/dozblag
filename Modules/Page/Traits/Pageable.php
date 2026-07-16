<?php

namespace Modules\Page\Traits;

use Modules\Page\Models\Page;

trait Pageable
{
    public function pages()
    {
        return $this->morphToMany(Page::class, 'pageable')->with('parentRecursive');
    }

    public function getStatusBrowse() {

        $status = null;

        switch ($this->status) {
            case 'PUBLISHED':
                $status = '<span class="badge badge-success center">منتشر شده</span>';
                break;
            case 'DRAFT':
                $status = '<span class="badge badge-danger center">عدم انتشار</span>';
                break;
        }
        echo $status;
    }

    public function scopePublished($query)
    {
        return $query->where($this->get_status_column(), 'PUBLISHED');
    }

    abstract function get_status_column():string;



}
