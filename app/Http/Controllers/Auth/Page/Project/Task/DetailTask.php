<?php

namespace App\Http\Controllers\Auth\Page\Project\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Tasks\Task;
use App\Models\Master\Tasks\FileTask;
use App\Models\Master\Tasks\ForumTask;

class DetailTask extends Controller
{
    public function HomePage(Request $req, $slug){
        $data = [];
        $result = Task::with(['anggota', 'project_task.users'])
        ->where('slug', $slug)
        ->where('is_active',true)
        ->where(function ($q) {
            $q->where('responsibility', auth()->user()->id_users)
              ->orWhereHas('project_task', function ($q2) {
                  $q2->where('pm', auth()->user()->id_users);
              });
        })
        ->first();

        if (!$result) {
            abort(404);
        }

        $fileTugas = FileTask::where('taks',$result->id_tasks)->get();

        $forum = ForumTask::with(['users','task','files'])
        ->where('tasks',$result->id_tasks)
        ->get();
        // dd($forum->toArray());
        $data['task'] = $result;
        $data['forum'] = $forum;
        $data['files'] = $fileTugas;
        return view('Auth.Project.Task.detail_task',$data);
    }
}
