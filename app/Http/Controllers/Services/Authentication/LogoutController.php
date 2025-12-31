<?php

namespace App\Http\Controllers\Services\Authentication;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController
{
    public function LogoutHandler(Request $req){
        Auth::logout(); // Log the user out

        $req->session()->invalidate(); // Invalidate their session

        $req->session()->regenerateToken();

        return redirect()->route('login');
    }
}
