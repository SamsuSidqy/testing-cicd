<?php

namespace App\Http\Controllers\Services\Master\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;

use App\Models\Master\MemberProject;
use App\Models\Master\Project;
use App\Models\Master\Tasks\Task;

class UpdateController extends Controller
{
    public function updateProject(Request $req){        
        $validasi = $req->validate([
            'id_project' => 'required',
            'title' => 'required',
            'deskripsi' => 'required',
            'start' => 'required',
            'ended' => 'required',
            'latitude' => 'required',
            'lontitude' => 'required'
        ]);

        Project::where('id_projects',$validasi['id_project'])->update([
            'title' => $validasi['title'],
            'start' => DateTime::createFromFormat('d F Y',$validasi['start']),
            'ended' => DateTime::createFromFormat('d F Y',$validasi['ended']),
            'deskripsi' => $validasi['deskripsi'],
            'latitude' => $validasi['latitude'],
            'lontitude' => $validasi['lontitude']
        ]);

        return redirect()->back()->with('success','Project Berhasil Di Perbarui');
    }

    public function updateKickUsers(Request $req){
        $validasi = $req->validate([
            'id_user' => 'required',
            'id_project' => 'required'
        ]);

        try{
            DB::beginTransaction();

            Task::where('responsibility',$validasi['id_user'])->update([
                'is_active' => false
            ]);

            MemberProject::where('id_projects',$validasi['id_project'])->where('id_users',$validasi['id_user'])->delete();

            DB::commit();

            return redirect()->back()->with('success','User Telah Di Kick Dari Project');

        }catch(Exception $err){
            DB::rollback();

            return redirect()->back()->with('success','Gagal Mengekick User Dari Projects');
        }

    }

    public function updateAddUsers(Request $req){        
        $validasi = $req->validate([
            'users' => 'required',
            'id_projects' => 'required'
        ]);
        $payload = [];
        foreach($validasi['users'] as $data){
            $payload[] = [
                'id_projects' => $validasi['id_projects'],
                'id_users' => $data
            ];
        }
        MemberProject::insert($payload);
        return redirect()->back()->with('success','User Berhasil Di Tambahkan');
    }

    public function updateDeleteProjects(Request $req){
        $validasi = $req->validate([
            'id_projects' => 'required'
        ]);
        Project::where('id_projects',$validasi['id_projects'])->update([
            'deleted' => true
        ]);
        return redirect()->back()->with('success','Project Berhasill Di Hapus');
    }

}
