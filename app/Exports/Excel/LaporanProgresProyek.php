<?php

namespace App\Exports\Excel;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Illuminate\Contracts\View\View;

use App\Models\Master\Project;
use App\Models\Master\Tasks\Task;

class LaporanProgresProyek implements FromView, WithColumnWidths
{
    protected $project;
    protected $taks;

    public function __construct($projects,$tasks){
        $this->project = $projects;
        $this->tasks = $tasks;
    }

    public function view(): View
    {
        $data = [];
        $data['project'] = $this->project;
        $data['task'] = $this->tasks;
        return view('reports.reports_proyek_progress',$data);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,   
            'B' => 18,  
            'C' => 18,  
            'D' => 25,  
            'E' => 25,  
            'F' => 15,  
            'G' => 30,  
        ];
    }

}
