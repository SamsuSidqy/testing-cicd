<?php

use App\Models\Master\Tasks\Task;
use Carbon\Carbon;

if (!function_exists('persentase_task')) {
    function persentase_task($project) {
        $taskStats = Task::where('project', $project)
                ->where('is_active',true)
                 ->selectRaw('COUNT(*) as total, SUM(CASE WHEN status="Completed" THEN 1 ELSE 0 END) as completed')
                 ->first();
        $data = $taskStats->total > 0 
                              ? ($taskStats->completed / $taskStats->total) * 100 
                              : 0;
        return round($data) ?? 0;
    }
}

if (!function_exists('hitung_deadline')) {
    function hitung_deadline($datetime)
    {   

        Carbon::setLocale('id');
        $now = Carbon::now();
        $target = Carbon::parse($datetime);

        if ($target->lessThanOrEqualTo($now)) {
            return "<span class='badge text-bg-danger b-r-0'>Deadline Sudah Lewat</span>";
        }
        
        return "<span class='badge text-bg-primary b-r-0'>".$target->diffForHumans($now, [
            'parts' => 1,
            'short' => false, // true = 1 jam lagi -> 1j
            'syntax' => Carbon::DIFF_RELATIVE_TO_NOW,
        ])."</span>";
    }
}

if (!function_exists('boolean_deadline')) {
    function boolean_deadline($datetime)
    {
        $now = Carbon::now();
        $target = Carbon::parse($datetime);

        // TRUE = masih waktu / belum lewat
        // FALSE = sudah lewat
        return $target->greaterThan($now);
    }
}