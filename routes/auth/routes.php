<?php 
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

use App\Models\Developer\MenuModels;

// Middleware
use App\Http\Middleware\DeveloperMiddleware;
use App\Http\Middleware\Prevents;

if (!app()->runningInConsole()) {
	// Developer Routes
	Route::middleware([Prevents::class,'auth',DeveloperMiddleware::class])->group(function(){
		if (Schema::hasTable('menu_cms')) {
			$cmsMenu = MenuModels::where('deleted',false)->where('is_active',true)->get();
			foreach($cmsMenu as $data){
				$controller = "\\App\\Http\\Controllers\\Auth\\Page";
				if (!empty($data->parrent_folder)) {
					$parent = trim($data->parrent_folder, '/\\');
					$parent = str_replace('/', '\\', $parent);
					$controller .= '\\' . $parent;
				}
				$controller .= "\\" . $data->class_name;
				if ($data->role === 'Developer') {
					Route::get($data->url, [$controller, $data->metode])
					->name($data->route_name);			
				}
			}
		}

		Route::get('/auth/developer/logging/page/{page}',[App\Http\Controllers\Auth\Page\Developer\LoggingPageController::class,'HomePage'])->name('auth.developer.logging.pagination');

	});

// All Routes
	Route::middleware([Prevents::class,'auth'])->group(function(){
		if (Schema::hasTable('menu_cms')) {
			$cmsMenu = MenuModels::where('deleted',false)->where('is_active',true)->get();
			foreach($cmsMenu as $data){
				$controller = "\\App\\Http\\Controllers\\Auth\\Page";
				if (!empty($data->parrent_folder)) {
					$parent = trim($data->parrent_folder, '/\\');
					$parent = str_replace('/', '\\', $parent);
					$controller .= '\\' . $parent;
				}

				$controller .= "\\" . $data->class_name;
				if (empty($data->role)) {
					Route::get($data->url, [$controller, $data->metode])
					->name($data->route_name);			
				}
			}
		}

		Route::get('/auth/project/detail/{slug}',[App\Http\Controllers\Auth\Page\Project\DetailProject::class,'HomePage'])->name('auth.project.detail');

		Route::get('/auth/project/detail/task/{slug}',[App\Http\Controllers\Auth\Page\Project\Task\DetailTask::class,'HomePage'])->name('auth.project.task.detail');

		Route::get('/auth/dashboard/master-users/page/{page}',[App\Http\Controllers\Auth\Page\Master\Users\MasterUsers::class,'HomePage'])->name('auth.dashboard.master.user.pagination');

		Route::get('/auth/project/reports/page/{page}',[App\Http\Controllers\Auth\Page\Project\ReportProjectController::class,'HomePage'])->name('auth.project.reports.pagination');

	});
}