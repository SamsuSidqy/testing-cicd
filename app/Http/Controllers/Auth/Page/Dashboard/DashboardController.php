<?php

namespace App\Http\Controllers\Auth\Page\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Master\Project;
use App\Models\Master\MemberProject;
use App\Models\Master\Tasks\Task;

class DashboardController extends Controller
{
    public function HomePage(Request $req)
    {
        $data = [];
       
        $data['task_complete'] = Task::where('responsibility',auth()->user()->id_users)
        ->where('is_active',true)
        ->where('status','Completed')->count();

        $data['task_progress'] = Task::where('responsibility',auth()->user()->id_users)
        ->where('is_active',true)
        ->where('status','Progress')->count();

        $data['total_task'] = Task::where('responsibility',auth()->user()->id_users)
        ->where('is_active',true)
        ->count();

        $data['task_priority'] = Task::where('responsibility',auth()->user()->id_users)
        ->where('is_active',true)
        ->where('deadline', '<=', now()->addDay())
        ->where('status','Progress')
        ->where('deadline', '>', now())->count();

        $data['task_terlambat'] = Task::where('responsibility',auth()->user()->id_users)
        ->where('status','Progress')
        ->where('is_active',true)
        ->where('extend_deadline',true)
        ->count();

        $data['total_project'] = MemberProject::with(['project'])
        ->whereHas('project',function($q){
            $q->where('deleted',false);
        })
        ->where('id_users',auth()->user()->id_users)->count();

        // Grapfik Chart Tren Tasks Complete
        $queyrTsk = $req->query('tsk') ?? now()->year;
        $taskCompletionTrend = Task::select(
            DB::raw('MONTH(updated_at) as month'),
            DB::raw('COUNT(*) as total')
        )
        ->where('responsibility',auth()->user()->id_users)
        ->where('is_active',true)
        ->where('status', 'Completed')
        ->where('extend_deadline',false)    
        ->whereYear('updated_at',$queyrTsk) 
        ->groupBy(DB::raw('MONTH(updated_at)'))
        ->orderBy('month')
        ->get();

               

        $resultsTaskCompleteTrend = collect(range(1, 12))->mapWithKeys(function ($month) {
            return [$month => 0];
        });
        $taskCompletionTrend->each(function ($item) use (&$resultsTaskCompleteTrend) {
            $resultsTaskCompleteTrend[$item->month] = $item->total;
        });

        $taskCompletionTrendLate = Task::select(
            DB::raw('MONTH(updated_at) as month'),
            DB::raw('COUNT(*) as total')
        )
        ->where('responsibility',auth()->user()->id_users)
        ->where('status', 'Completed')
        ->where('is_active',true)
        ->where('extend_deadline',true)
        ->whereYear('updated_at', $queyrTsk)
        ->groupBy(DB::raw('MONTH(updated_at)'))
        ->orderBy('month')
        ->get();
        $resultsTaskCompleteTrendLate = collect(range(1, 12))->mapWithKeys(function ($month) {
            return [$month => 0];
        });
        $taskCompletionTrendLate->each(function ($item) use (&$resultsTaskCompleteTrendLate) {
            $resultsTaskCompleteTrendLate[$item->month] = $item->total;
        });


        $data['trend_task_late'] = $resultsTaskCompleteTrendLate;
        $data['trend_task'] = $resultsTaskCompleteTrend;


        // GRaphic Trend Projects
        $queryPjk = $req->query('pjk') ?? now()->year;
        $trendProject = Project::select(
            DB::raw('MONTH(start) as month'),
            DB::raw('COUNT(*) as total')
        )
        ->whereHas('member', function($query) {
            $query->where('id_users', auth()->user()->id_users);
        })
        ->where('deleted',false)
        ->whereYear('start',$queryPjk)
        ->groupBy(DB::raw('MONTH(start)'))
        ->orderBy('month')
        ->get();

        $resultTrendProject = collect(range(1,12))->mapWithKeys(function($month){
            return [$month => 0];
        });

        $trendProject->each(function ($item) use (&$resultTrendProject){
            $resultTrendProject[$item->month] = $item->total;
        });       
        $data['trend_project'] = $resultTrendProject;
        

        return view('Auth.Dashboard.dashboard',$data);
    }
}
