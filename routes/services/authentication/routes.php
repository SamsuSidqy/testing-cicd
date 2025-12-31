<?php 
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Services\Authentication\LoginController;
use App\Http\Controllers\Services\Authentication\LogoutController;

use App\Http\Middleware\LoggingSuccess;

Route::middleware(['auth',LoggingSuccess::class])->group(function(){
	Route::post('/logout',[LogoutController::class,'LogoutHandler'])->name('service_logout');
});

Route::middleware(['throttle:10,1','guest',LoggingSuccess::class])->group(function(){

	Route::post('/login-authentication',[LoginController::class,'LoginHandler'])->name('service_login');
});

