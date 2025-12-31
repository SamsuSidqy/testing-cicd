<?php

namespace App\Http\Controllers\Services\Master\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;

use App\Models\Master\MemberProject;
use App\Models\Master\Project;

class CreateController extends Controller
{
    public function createProject(Request $req){

        /**
         * Melakukan Validasi Setiap Request Dikirim             
         * (Title) Validasi (Wajib Di Isi - Required)
         * (Deskripsi) Validasi (Wajib , Required)
         * (Start Project) Validasi (Wajib Di Isi - Required)
         * (Ended Project) Validasi (Wajib Di Isi - Required)
         * (Users) Validasi (Wajib Di Isi - Required)
         * (Latitude) Validasi (Wajib Di Isi - Required)
         * (Lontitude) Validasi (Wajib , Required)
        **/

        $validasi = $req->validate([
            'title' => 'required',
            'deskripsi' => 'required',
            'start' => 'required',
            'ended' => 'required',
            'users' => 'required|array',
            'latitude' => 'required',
            'lontitude' => 'required'
        ]);

        try{
            DB::beginTransaction();

            /**
             * Melakukan Store Data Project Kedalam Database
             **/
            $project = Project::create([
                'title' => $validasi['title'],
                'deskripsi' => $validasi['deskripsi'],
                'start' => DateTime::createFromFormat('d F Y',$validasi['start']),
                'ended' => DateTime::createFromFormat('d F Y',$validasi['ended']),
                'lontitude' => $validasi['lontitude'],
                'latitude' => $validasi['latitude'],
                'pm' => auth()->user()->id_users,
                'slug' => bin2hex(random_bytes(60 / 2))
            ]);

            /**
             * Melakukan Pengambilan Data Users Yang Berada Dalam Project
             **/
            $member = collect($validasi['users'])
                ->map(function ($item) use ($project) {
                    return [
                    'id_users'    => $item,
                    'id_projects' => $project->id_projects // pastikan PK benar
                ];
            })->toArray();

            // Payload Format Untuk Di Store Ke Database
            $member[] = [
                'id_users' => auth()->user()->id_users,
                'id_projects' => $project->id_projects
            ];


            /**
             * Melakukan Store Ke Dalam Database
             **/
            MemberProject::insert($member);
            DB::commit();
            return redirect()->back()->with('success','Project Berhasil Di Buat');
        }catch(Exception $err){
            DB::rollback();        
            return redirect()->back()->with('error','Project Gagal Di Buat');
        }   

    }
}
