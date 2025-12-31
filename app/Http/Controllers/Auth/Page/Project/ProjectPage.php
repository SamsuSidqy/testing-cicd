<?php

namespace App\Http\Controllers\Auth\Page\Project;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Master\MemberProject;

class ProjectPage extends Controller
{
    public function HomePage(Request $req)
    {
        $data = [];
        $data['myproject'] = MemberProject::with(['project.member.users'])
        ->whereHas('project',function($q){
            $q->where('deleted',false);
        })
        ->where('id_users',auth()->user()->id_users)->get();

        return view('Auth.Project.project',$data);
    }
}
