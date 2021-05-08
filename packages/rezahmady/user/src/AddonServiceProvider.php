<?php

namespace Rezahmady\User;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Rezahmady\User\Http\Livewire\Auth\FormLogin;
use Rezahmady\User\Http\Livewire\Auth\FormValidation;
use Rezahmady\User\Http\Livewire\Auth\Login;
use Rezahmady\User\Http\Livewire\Widgets\ListUser;

class AddonServiceProvider extends ServiceProvider
{
    use AutomaticServiceProvider;

    protected $vendorName = 'rezahmady';
    protected $packageName = 'user';
    protected $commands = [];

    public function moduleBoot() : void
    {
        Livewire::component('widgets.list-user', ListUser::class);
        Livewire::component('auth.form-validation', FormValidation::class);
        Livewire::component('rezahmady.user.http.livewire.auth.form-validation', FormValidation::class);
        Livewire::component('auth.form-login', FormLogin::class);
        Livewire::component('rezahmady.user.http.livewire.auth.form-login', FormLogin::class);
        Livewire::component('rezahmady.user.http.livewire.auth.login', Login::class);
    }

    public function menuBuilder($menu)
    {
        if(backpack_user()->can('user manage')){
            
                $menu->add('users', ' مدیریت کاربران', '#' , 100 , 'users');
                $menu->add('users.user', trans('backpack::permissionmanager.users') , backpack_url('user') , 110, 'user');
                if(backpack_user()->can('role manage'))
                    $menu->add('users.role', trans('backpack::permissionmanager.roles') , backpack_url('role') , 120, 'id-badge');
                if(backpack_user()->can('permission manage'))
                    $menu->add('users.permission', trans('backpack::permissionmanager.permission_plural') , backpack_url('permission') , 130, 'key');
        } 

    }
}
