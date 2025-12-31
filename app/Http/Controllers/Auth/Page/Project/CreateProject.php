<?php

namespace App\Http\Controllers\Auth\Page\Project;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Authentication\Users;

class CreateProject extends Controller
{
    public function HomePage(Request $req)
    {
        $data = [];
        $data['users'] = Users::where('id_users','!=',auth()->user()->id_users)
        ->where('roles','!=','Manager')
        ->where('roles','!=','Admin')
        ->where('roles','!=','Developer')
        ->get();
        return view('Auth.Project.create_project',$data);
    }
}
