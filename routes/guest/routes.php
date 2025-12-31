<?php 

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Guest\LoginController;
use App\Events\Forum\Notification;


Route::middleware([App\Http\Middleware\LogginMiddleware::class,'guest'])->group(function(){	
	Route::get('/',[LoginController::class,'index'])->name('login');	
});


