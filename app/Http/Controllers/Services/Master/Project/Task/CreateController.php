<?php

namespace App\Http\Controllers\Services\Master\Project\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTime;

use App\Models\Master\Tasks\Task;

class CreateController extends Controller
{
    public function createTasks(Request $req){       
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $sluggify = substr(str_shuffle($characters), 0, 60);

        $validasi = $req->validate([
            'project' => 'required',
            'name' => 'required',
            'responsibility' => 'required',
            'deadline' => 'required',
            'slug' => 'nullable'
        ]);
        $validasi['slug'] = $sluggify;
        $validasi['deadline'] = DateTime::createFromFormat('d F Y',$validasi['deadline']);
        Task::create($validasi);
        return redirect()->back()->with('success','Pembuatan Tugas Berhasil Dilakukan');
    }
}
