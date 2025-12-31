<?php
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function(){	

	// Services
	Route::post('/developer-service/create/badge',[App\Http\Controllers\Services\Developer\MenuServices::class,'storeBadges'])->name('service_developer_badge_create');

	Route::post('/developer-service/create/sub',[App\Http\Controllers\Services\Developer\MenuServices::class,'storeSub'])->name('service_developer_sub_create');

	Route::post('/developer-service/create/menu',[App\Http\Controllers\Services\Developer\MenuServices::class,'storeMenu'])->name('service_developer_menu_create');

	Route::post('/developer-service/update/permission',[App\Http\Controllers\Services\Developer\PermissionServices::class,'updatePermission'])->name('service_developer_permission_update');

	Route::put('/developer-service/update/badges',[App\Http\Controllers\Services\Developer\MenuServices::class,'updateBadges'])->name('service_developer_badge_update');
	Route::put('/developer-service/delete/badges',[App\Http\Controllers\Services\Developer\MenuServices::class,'deleteBadges'])->name('service_developer_badge_delete');

	Route::put('/developer-service/update/sub',[App\Http\Controllers\Services\Developer\MenuServices::class,'updateSub'])->name('service_developer_sub_update');
	Route::put('/developer-service/delete/sub',[App\Http\Controllers\Services\Developer\MenuServices::class,'deleteSub'])->name('service_developer_sub_delete');

	Route::put('/developer-service/update/menu',[App\Http\Controllers\Services\Developer\MenuServices::class,'updateMenu'])->name('service_developer_menu_update');
	Route::delete('/developer-service/delete/menu',[App\Http\Controllers\Services\Developer\MenuServices::class,'deleteMenu'])->name('service_developer_menu_delete');



	// Reports
	Route::get('/developer-service/report/log/detail',[App\Http\Controllers\Services\Developer\ReportsData::class,'reportDetailLogging'])->name('service_developer_report_log_detail');

});