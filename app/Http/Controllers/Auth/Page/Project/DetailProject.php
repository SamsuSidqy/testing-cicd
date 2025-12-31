<?php

namespace App\Http\Controllers\Auth\Page\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Master\MemberProject;
use App\Models\Master\Tasks\Task;
use App\Models\Authentication\Users;

class DetailProject extends Controller
{
    public function HomePage(Request $req, $slug){
        $data = [];

        $result = MemberProject::with(['project.member.users'])
        ->where('id_users', auth()->user()->id_users)
        ->whereHas('project', function($query) use ($slug) {
            $query->where('slug', $slug);
            $query->where('deleted',false);
        })
        ->first();

        if (!$result) {
            abort(404);
        }
        
        $data['task'] = Task::with(['anggota','project_task'])->where('project',$result->project->id_projects)->where('is_active',true)->get();
        // dd($data['task']->toArray());

        $taskStats = Task::where('project', $result->project->id_projects)
                 ->where('is_active',true)
                 ->selectRaw('COUNT(*) as total, SUM(CASE WHEN status="Completed" THEN 1 ELSE 0 END) as completed')
                 ->first();
        
        $data['persentase'] = $taskStats->total > 0 
                              ? ($taskStats->completed / $taskStats->total) * 100 
                              : 0;
        
        $data['project'] = $result;

        $data['users'] = Users::where('roles','Employe')->orWhere('roles','Admin')->get();

        return view('Auth.Project.detail_project',$data);
    }
}
