<?php

namespace App\Http\Controllers\Guest;

use Illuminate\Http\Request;

class LoginController
{
    public function index(Request $req){
        return view('Guest.login');
    }
}
