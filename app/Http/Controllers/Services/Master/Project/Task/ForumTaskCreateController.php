<?php

namespace App\Http\Controllers\Services\Master\Project\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

use App\Events\TaskForum;
use App\Events\Notification;

use App\Models\Master\Tasks\FileTask;
use App\Models\Master\Tasks\ForumTask;
use App\Models\Master\Tasks\Task;

class ForumTaskCreateController extends Controller
{
    public function KirimPesan(Request $req){
        $validasi = $req->validate([
            'files' => 'nullable | array',
            'files.*' => 'nullable|file|mimes:jpg,jpeg,png,zip,pdf,docx|max:15240', // Max 15 MB
            'tasks' => 'required',
            'name' => 'required',
            'sender' => 'required',
            'message' => 'nullable',
            'type' => 'nullable',            
        ]);

        DB::beginTransaction();
        try{

            $forum = ForumTask::create([
                'message' => $validasi['message'] ?? null,
                'sender' => auth()->user()->id_users,
                'type' => $validasi['type'] ?? 'Pesan',
                'tasks' => $validasi['tasks']
            ]);

            $dataImage = [];
            if ($req->hasFile('files')) {
                $files = $req->file('files');
                foreach ($files as $file) {

                    // Untuk Membuat Nama Format Files
                    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                    $randomString = substr(str_shuffle($chars), 0, 5);

                    $name = auth()->user()->name . '-' . $randomString . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('file-task',$name);
                    $tipe_file_image = in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png']);
                    $typeFile = $tipe_file_image ? 'image' : 'file';

                    $dataImage[] = [
                        'name_file' => $name,
                        'type' => $typeFile,
                        'forum' => $forum->id_forum,
                        'taks' => $validasi['tasks']
                    ];
                }
                FileTask::insert($dataImage);              
            }

            Carbon::setLocale('id');
            $waktu = Carbon::now()->translatedFormat('l, d F Y, H:i:s');

            $pesan = [
                'pesan' => $validasi['message'] ?? null,
                'files' => count($dataImage) ? $dataImage : null,
                'waktu' => $waktu
            ];

            //  Kirim Pesan
            broadcast(new TaskForum(
                $pesan,
                $validasi['sender'],
                $validasi['name'],
                $validasi['type'] ?? 'Pesan',
                $validasi['tasks'],                
            ));


            // Kirim Notifikasi
            // Ambil Datanya
            $dataNotif = Task::with(['project_task.users','anggota'])->where('id_tasks',$validasi['tasks'])
            ->first();

            if ($dataNotif) {
                // Cek Notif Di Kirim Dari Siapa
                $from = null;
                // Cek Notif Di Kirim Untuk SIapa
                $to = null;
                if (auth()->user()->id_users == $dataNotif->responsibility) { // Cek PIC / NOT
                    $from =  $dataNotif->anggota; 
                    $to = $dataNotif->project_task->users;
                }else{
                    $from = $dataNotif->project_task->users; 
                    $to = $dataNotif->anggota; 
                }

                $payload = [
                    'type' => 'Pesan',
                    'from' => $from,
                    'message' => $validasi['message'],
                    'slug' => $dataNotif->slug
                ];
                broadcast(new Notification($payload,$to->id_users));
            }

            DB::commit();

            return response()->json([
                'status' => true,                
                'data' => $dataImage,                
            ]);

        }catch(Exception $err){
            DB::rollback();
            return response()->json([
                'status' => false
            ]);
        }

        
    }

    public function LihatFileTasks(Request $req, $filename){
        // Tentukan path file berdasarkan nama file
        $path = storage_path('app/private/file-task/' . $filename);

        // Cek apakah file ada
        if (!File::exists($path)) {
            abort(404, "File not found.");
        }

        // Mendapatkan tipe MIME file
        $mimeType = mime_content_type($path);
        $fileExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        // Jika file adalah gambar (misalnya jpg, jpeg, png, gif)
        $imageTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($fileExtension, $imageTypes)) {
            // Menampilkan gambar di browser
            return response()->file($path, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline', // Menampilkan file di dalam browser
            ]);
        }
        
        // Jika file adalah PDF atau DOCX, untuk mengunduh file
        $downloadableTypes = ['pdf', 'docx'];
        if (in_array($fileExtension, $downloadableTypes)) {
            // Menyediakan file untuk diunduh
            return response()->download($path, $filename, [
                'Content-Type' => $mimeType
            ]);
        }

        // Jika file bukan gambar atau tipe yang ditentukan, batalkan dengan 404
        abort(404, "Unsupported file type.");
    
    }
}
