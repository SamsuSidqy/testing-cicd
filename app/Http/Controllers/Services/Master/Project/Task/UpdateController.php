<?php

namespace App\Http\Controllers\Services\Master\Project\Task;

use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;
use Carbon\Carbon;

use App\Models\Master\Tasks\Task;

class UpdateController extends Controller
{
    public function updateStatusTask(Request $req){
        $validasi = $req->validate([
            'id_tasks' => 'required',
            'status' => 'nullable'
        ]);

        Task::where('id_tasks',$validasi['id_tasks'])->update([
            'status' => $validasi['status'] ? 'Completed' : 'Progress'
        ]);
        return redirect()->back()->with('success','Pembaruan Berhasil Dilakukan');
    }

    public function updateTask(Request $req){
    
        $validasi = $req->validate([
            'id_tasks' => 'required',
            'name' => 'required',
            'responsibility' => 'required',
            'deadline' => 'nullable'
        ]);

        $result = Task::where('id_tasks',$validasi['id_tasks'])->first();
        if (!$result) {
            throw ValidationException::withMessages([
                'id_tasks' => ['Task TIdak Di Temukan. Id Salah'],
            ]);
        }
        
        $payload;
        if($validasi['deadline']){
            Carbon::setLocale('id');
            $now = Carbon::now();
            $target = Carbon::parse($result->deadline);
            if ($target->lessThanOrEqualTo($now)) {
                $payload = [
                    'deadline' => DateTime::createFromFormat('d F Y',$validasi['deadline']),
                    'name' => $validasi['name'],
                    'responsibility' => $validasi['responsibility'],
                    'extend_deadline' => true
                ];
            }else{
                $payload = [
                    'deadline' => DateTime::createFromFormat('d F Y',$validasi['deadline']),
                    'name' => $validasi['name'],
                    'responsibility' => $validasi['responsibility']
                ];
            }
        }else{
            $payload = [
                'name' => $validasi['name'],
                'responsibility' => $validasi['responsibility']
            ];
        }

        Task::where('id_tasks',$validasi['id_tasks'])->update($payload);
        return redirect()->back()->with('success','Update Task Berhasil Di Lakukan');       

    }

    public function updateDeleteTask(Request $req){
        $validasi = $req->validate([
            'id_tasks' => 'required'
        ]);
        Task::where('id_tasks',$validasi['id_tasks'])->update([
            'is_active' => false
        ]);
        return redirect()->back()->with('success','Task Berhasil Di Hapus');
    }
}
