<?php

namespace App\Exports\PDF;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

// Models
use App\Models\Master\Project;

class LaporanProgresProyek
{
    protected $project;
    protected $task;

    public function __construct($project, $task)
    {
        $this->task = $task;
        $this->project = $project;
    }

    public function generatePDF()
    {        
        // Data to be passed to the view
        $data = [
            'project' => $this->project,
            'task' => $this->task,
        ];

        // Generate PDF
        $pdf = Pdf::loadView('reports.reports_proyek_progress', $data);

        // Return PDF
        return $pdf->download('laporan_proyek_progress_'.$this->project->title.'.pdf');
    }
}
