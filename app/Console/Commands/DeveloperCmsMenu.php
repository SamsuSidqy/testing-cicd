<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

use App\Models\Developer\MenuModels;
use App\Models\Developer\BadgesMenuModels;
use App\Models\Developer\SubMenuModels;

class DeveloperCmsMenu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $badge_menu = array(
      array('id_badge_menu' => '1','name' => 'Dashboard','is_active' => '1','deleted' => '0','created_at' => '2025-12-13 22:12:18'),
      array('id_badge_menu' => '2','name' => 'Developer','is_active' => '1','deleted' => '0','created_at' => '2025-12-14 09:34:56'),
      array('id_badge_menu' => '3','name' => 'Project','is_active' => '1','deleted' => '1','created_at' => '2025-12-15 10:13:47'),
      array('id_badge_menu' => '4','name' => 'Project','is_active' => '1','deleted' => '0','created_at' => '2025-12-15 11:35:20')
    );
    protected $sub_menu = array(
      array('id_sub_menu' => '1','name' => 'Dashboard','badge' => '1','is_active' => '1','deleted' => '0','icon' => '<i class="ph-fill  ph-grid-four"></i>','created_at' => '2025-12-13 22:26:34'),
      array('id_sub_menu' => '2','name' => 'Developer','badge' => '2','is_active' => '1','deleted' => '0','icon' => '<i class="ph-fill  ph-code"></i>','created_at' => '2025-12-14 09:35:12'),
      array('id_sub_menu' => '4','name' => 'Project','badge' => '4','is_active' => '1','deleted' => '0','icon' => '<i class="ph ph-projector-screen-chart"></i>','created_at' => '2025-12-15 11:38:44')
    );
    protected $menu_cms = array(
      array('id_menu_cms' => '1','name' => 'Dashboard','url' => '/auth/dashboard','is_active' => '1','deleted' => '0','role' => NULL,'parrent_folder' => 'Dashboard','metode' => 'HomePage','route_name' => 'auth.dashboard','class_name' => 'DashboardController','name_views' => 'dashboard','sub' => '1','created_at' => '2025-12-14 09:25:12'),
      array('id_menu_cms' => '2','name' => 'Menu CMS','url' => '/auth/developer/cms-menu','is_active' => '1','deleted' => '0','role' => 'Developer','parrent_folder' => 'Developer','metode' => 'HomePage','route_name' => 'auth.developer.cms.menu','class_name' => 'MenuCmsController','name_views' => 'menu_cms','sub' => '2','created_at' => '2025-12-14 09:37:20'),
      array('id_menu_cms' => '3','name' => 'Permission','url' => '/auth/developer/permission-menu','is_active' => '1','deleted' => '0','role' => 'Developer','parrent_folder' => 'Developer/Permissions','metode' => 'HomePage','route_name' => 'auth.developer.cms.permission.menu','class_name' => 'PermissionMenuController','name_views' => 'permissions','sub' => '2','created_at' => '2025-12-14 10:22:38'),
      array('id_menu_cms' => '4','name' => 'Project Saya','url' => '/auth/project/me','is_active' => '1','deleted' => '0','role' => NULL,'parrent_folder' => 'Project','metode' => 'HomePage','route_name' => 'auth.project.me','class_name' => 'ProjectPage','name_views' => 'project','sub' => '4','created_at' => '2025-12-15 11:40:09'),
      array('id_menu_cms' => '5','name' => 'Buat Project','url' => '/auth/project/create','is_active' => '1','deleted' => '0','role' => NULL,'parrent_folder' => 'Project','metode' => 'HomePage','route_name' => 'auth.project.create','class_name' => 'CreateProject','name_views' => 'create_project','sub' => '4','created_at' => '2025-12-15 11:45:08'),
      array('id_menu_cms' => '6','name' => 'Master Users','url' => '/auth/dashboard/master-users','is_active' => '1','deleted' => '0','role' => NULL,'parrent_folder' => 'Master/Users','metode' => 'HomePage','route_name' => 'auth.dashboard.master.user','class_name' => 'MasterUsers','name_views' => 'master_users','sub' => '1','created_at' => '2025-12-15 11:49:23'),
      array('id_menu_cms' => '7','name' => 'Logging','url' => '/auth/developer/logging','is_active' => '1','deleted' => '0','role' => 'Developer','parrent_folder' => 'Developer','metode' => 'HomePage','route_name' => 'auth.developer.logging','class_name' => 'LoggingPageController','name_views' => 'logging','sub' => '2','created_at' => '2025-12-21 19:46:29')
    );
    protected $signature = 'developer:menu-cms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try{
            if (Schema::hasTable('badge_menu')) {
                BadgesMenuModels::insert($this->badge_menu);
                if (Schema::hasTable('sub_menu')) {
                    SubMenuModels::insert($this->sub_menu);
                    if (Schema::hasTable('menu_cms')) {
                        MenuModels::insert($this->menu_cms);
                    }else{
                        $this->info('Table Menu Cms Belum Tersedia');
                    }
                }else{
                    $this->info('Tabel Menu Sub Belum Tersedia');
                }
            }else{
                $this->info('Table Badge Belum Tersedia');
            }
        }catch(Exception $err){
            $this->error('Gagal Memperbarui Menu Cms' . $err->getMessage());
        }
    }
}
