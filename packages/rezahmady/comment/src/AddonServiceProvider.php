<?php

namespace Rezahmady\Comment;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Rezahmady\Comment\Http\Livewire\Comment;
use Rezahmady\Comment\Http\Livewire\CommentHolder;
use Rezahmady\Comment\Http\Livewire\CreateComment;
use TorMorten\Eventy\Facades\Eventy;

class AddonServiceProvider extends ServiceProvider
{
    use AutomaticServiceProvider;

    protected $vendorName = 'rezahmady';
    protected $packageName = 'comment';
    protected $commands = [];

    public function moduleBoot() : void
    {
        Livewire::component('comment.comment', Comment::class);
        Livewire::component('comment.comment-holder', CommentHolder::class);
        Livewire::component('comment.create-comment', CreateComment::class);

        Eventy::addAction('admin-menu-build', function($menu) { 
            if(backpack_user()->can('post manage') and backpack_user()->can('comment list')) {
                $menu->add('articles.comments', trans('rezahmady.comment::comment.article_comments') , backpack_url('article/comment') , 430, 'comments');
            }
    
            if(backpack_user()->can('user manage') and backpack_user()->can('comment list')) {
                $menu->add('users', ' مدیریت کاربران', '#' , 100 , 'users');
                $menu->add('users.comments', trans('rezahmady.comment::comment.doctor_comment') , backpack_url('user/doctor/comment') , 140, 'comments');
            }
        }, 21, 1);
    }
}
