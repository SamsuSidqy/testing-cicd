<?php

namespace App\Http\Controllers\Services\Master\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Exports\Excel\LaporanProyekPeriode;
use App\Exports\Excel\LaporanProgresProyek;

use Maatwebsite\Excel\Facades\Excel;

use App\Exports\PDF\LaporanProyekPeriode as pdfsProyekPeriode;
use App\Exports\PDF\LaporanProgresProyek as pdfsProyekProgress;

use App\Models\Master\Project;
use App\Models\Master\Tasks\Task;

class ReportController extends Controller
{
    public function ReportsProject(Request $req){        

            $type = $req->query('tipe');
            $tahun = $req->query('t');
            $bulan = $req->query('b');
            $pci = $req->query('pci');

        if (!$type) {
            abort(404);
        }

        if ($type === 'pdf') {
            $pdf = new pdfsProyekPeriode($bulan,$tahun,$pci);
            return $pdf->generatePDF();
        }else{
            return Excel::download(new LaporanProyekPeriode($bulan,$tahun,$pci), 'user_reports.xlsx');
        }
        return redirect()->back();
    }

    public function ReportProgressProject(Request $req){
        $idProject = $req->query('id');
        $files = $req->query('files');

        $project = Project::with(['users'])->where('id_projects',$idProject)->first();

        if (!$idProject or !$project or !$files) {
            abort(404);
        }
        $result = Task::with(['anggota','project_task.users','activity'])        
        ->whereHas('project_task',function($q) use($project){
            $q->where('id_projects',$project->id_projects);
        })        
        ->where('is_active',true)
        ->get() ?? [];
       
        if ($files === 'pdf') {
            $pdf = new pdfsProyekProgress($project,$result);
            return $pdf->generatePDF();
        }else{
            return Excel::download(new LaporanProgresProyek($project,$result),'reprots_progres.xlsx');
        }

        return redirect()->back();

    }

    
}
