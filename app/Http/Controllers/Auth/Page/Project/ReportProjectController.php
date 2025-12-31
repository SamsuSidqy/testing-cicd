<?php

namespace App\Http\Controllers\Auth\Page\Project;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Illuminate\Pagination\Paginator;
use Carbon\Carbon;

use App\Models\Master\Project;
use App\Models\Master\Tasks\Task;
use App\Models\Authentication\Users;

class ReportProjectController extends Controller
{
    public function HomePage(Request $req, $page = 1)
    {
        $data = [];
        $data['tahunProject'] = Project::select(DB::raw('YEAR(start) as tahun'))
        ->distinct()
        ->get();

        $data['bulanProject'] = Project::select(DB::raw('MONTH(start) as month'))
        ->distinct()
        ->get();

        $data['project'] = Project::with(['member'])->where('deleted',false)->get();
        $data['users'] = Users::where('roles','!=','Employe')->get();

        $progres = $req->query('progres');
        $projek = $req->query('projek');

        if ($projek) {

            Paginator::currentPageResolver(function () use ($page) {
                return $page;
            });

            $tahun = $req->query('t') ?? Carbon::now()->year;
            $bulan = $req->query('b') ?? Carbon::now()->month;
            $pci = $req->query('pci');

            // Query data for the selected period
            $projects = Project::with(['users', 'member'])
                ->whereYear('start', $tahun)
                ->whereMonth('start', $bulan)
                ->when($pci, function($query) use ($pci){
                    return $query->where('pm', $pci);
                })
                ->orderBy('start','desc')
                ->paginate(2);

            $periode = '1 - ' . Carbon::create($tahun, $bulan, 1)
                ->endOfMonth()
                ->translatedFormat('d') . ' ' .
                Carbon::create($tahun, $bulan, 1)
                    ->locale('id')
                    ->translatedFormat('F Y');

            $periodeTitle = Carbon::create($tahun, $bulan, 1)
                ->locale('id')
                ->translatedFormat('F Y');

            $data['report_project'] = [
                'project' => $projects,
                'periode' => $periode,
                'periodeTitle' => $periodeTitle
            ];

        }else if($progres){
            Paginator::currentPageResolver(function () use ($page) {
                return $page;
            });

            $idProject = $req->query('id');
            $project = Project::with(['users'])->where('id_projects',$idProject)->first();

            $data['report_progres'] = null;

            if ($idProject or $project) {
                $results = Task::with(['anggota','project_task.users','activity'])        
                    ->whereHas('project_task',function($q) use($project){
                        $q->where('id_projects',$project->id_projects);
                    })        
                    ->where('is_active',true)
                    ->paginate(1);
                $data['report_progres'] = [
                    'project' => $project,
                    'task' => $results
                ];
            }

        }
            
        return view('Auth.Project.report_projects',$data);
    }
}
