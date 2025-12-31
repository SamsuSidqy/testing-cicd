<?php 
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\LoggingSuccess;

Route::middleware(['auth'])->group(function(){
	/* --- Melihat File Task (Authorization) ---*/
	Route::get('/auth/file-task/{filename}',[App\Http\Controllers\Services\Master\Project\Task\ForumTaskCreateController::class,'LihatFileTasks'])->name('auth.service.look.file.task');
	/*
	=====================================
	Services Reports
	=====================================
	*/

	Route::get('/auth/services/project/reports',[App\Http\Controllers\Services\Master\Project\ReportController::class,'ReportsProject'])->name('auth.service.reports.project');


	Route::get('/auth/services/project/progress/reports',[App\Http\Controllers\Services\Master\Project\ReportController::class,'ReportProgressProject'])->name('auth.service.reports.project.progress');

	/*
	=====================================
	End Service Reports
	=====================================
	*/
	
});

Route::middleware([App\Http\Middleware\Prevents::class,'auth',LoggingSuccess::class])->group(function(){
	
	/*
	====================================
	Routes Service Untuk Master User (Create Update Delete)
	====================================
	*/

	Route::post('/auth/services/create/users',[App\Http\Controllers\Services\Master\Users\CreateController::class,'createUser'])->name('auth.service.create.user');

	Route::put('/auth/services/update/users',[App\Http\Controllers\Services\Master\Users\UpdateController::class,'UpdateUsers'])->name('auth.service.update.user');

	Route::put('/auth/services/update/profile',[App\Http\Controllers\Services\Master\Users\UpdateController::class,'UpdateProfile'])->name('auth.service.update.profile');

	Route::put('/auth/services/update/delete/users',[App\Http\Controllers\Services\Master\Users\UpdateController::class,'DeleteUsers'])->name('auth.service.delete.user');

	/*
	=====================================
	End Service Routes Master User
	=====================================
	*/

/*--------------------------------------------------------*/

	/*
	====================================
	Routes Service Untuk Master Project (Create Update Delete)
	====================================
	*/

	Route::post('/auth/services/create/project',[App\Http\Controllers\Services\Master\Project\CreateController::class,'createProject'])->name('auth.service.create.project');

	Route::put('/auth/services/update/project',[App\Http\Controllers\Services\Master\Project\UpdateController::class,'updateProject'])->name('auth.service.update.project');
	/*--- Kick Users ---*/
	Route::put('/auth/services/update/kick-user',[App\Http\Controllers\Services\Master\Project\UpdateController::class,'updateKickUsers'])->name('auth.service.update.project.kick');
	/*--- Add Users ---*/
	Route::put('/auth/services/update/add-user',[App\Http\Controllers\Services\Master\Project\UpdateController::class,'updateAddUsers'])->name('auth.service.update.project.add');
	/*--- Delete Projects ---*/
	Route::put('/auth/services/delete/project',[App\Http\Controllers\Services\Master\Project\UpdateController::class,'updateDeleteProjects'])->name('auth.service.delete.project');

	/*
	=====================================
	End Service Routes Master Project
	=====================================
	*/

/*--------------------------------------------------------*/
	/*
	====================================
	Routes Service Untuk Master Tasks
	====================================
	*/

	Route::post('/auth/services/create/tasks',[App\Http\Controllers\Services\Master\Project\Task\CreateController::class,'createTasks'])->name('auth.service.create.task');

	/* --- Kirim Pesan Broadcast Forum Tasks-- */
	Route::post('/auth/services/create/broadcast/task',[App\Http\Controllers\Services\Master\Project\Task\ForumTaskCreateController::class,'KirimPesan'])->name('auth.service.create.broadcast.task')->middleware(['throttle:15,1']);

	/* --- Update Status Tasks --- */
	Route::put('/auth/services/update/status/task',[App\Http\Controllers\Services\Master\Project\Task\UpdateController::class,'updateStatusTask'])->name('auth.service.update.status.task');

	/* --- Update Task --- */
	Route::put('/auth/services/update/task',[App\Http\Controllers\Services\Master\Project\Task\UpdateController::class,'updateTask'])->name('auth.service.update.task');
	
	/*--- Delete Tasks ---*/
	Route::put('/auth/services/delete/task',[App\Http\Controllers\Services\Master\Project\Task\UpdateController::class,'updateDeleteTask'])->name('auth.service.delete.task');


	/*
	=====================================
	End Service Routes Master Tasks
	=====================================
	*/




});