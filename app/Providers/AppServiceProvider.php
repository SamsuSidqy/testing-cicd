<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;

use App\Models\Developer\BadgesMenuModels;
use App\Models\Developer\PermissionUsers;

use App\Models\Master\Tasks\Task;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layout.dashboard',function($view){
            $data = [];            

            if (Schema::hasTable('badge_menu')) {
                $data['newMenu'] = BadgesMenuModels::with(['sub_menu.menu'])->get();
            } else {
                $data['newMenu'] = [];
            }


            $view->with('menu',$data);
        });

        Blade::if('hasPermissionsUsers', function ($slug, $user, $permission) {
            if (!Schema::hasTable('role_permission_users')) {
                return false;
            }

            $menus = PermissionUsers::where('id_users', $user)
                ->whereHas('menu', function($q) use ($slug) {
                    $q->where('url', "/".$slug);
                })
                ->with(['menu' => function($q) use ($slug) {
                    $q->where('url', "/".$slug);
                }])
                ->first();
            
            if (!$menus || !isset($menus->{$permission})) {
                return false;
            }

            return $menus->{$permission} == 1;  // check create, update, delete
        });

        Blade::if('hasPermissionsUsersMenuTab', function ($slug, $user, $permission) {
            if (!Schema::hasTable('role_permission_users')) {
                return false;
            }

            $menus = PermissionUsers::where('id_users', $user)
                ->whereHas('menu', function($q) use ($slug) {
                    $q->where('url', $slug);
                })
                ->with(['menu' => function($q) use ($slug) {
                    $q->where('url', $slug);
                }])
                ->first();
            
            if (!$menus || !isset($menus->{$permission})) {
                return false;
            }

            return $menus->{$permission} == 1;  // check create, update, delete
        });
        

    }
}
