<?php

namespace App\Exports\PDF;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

// Models
use App\Models\Master\Project;

class LaporanProyekPeriode
{
    protected $periodeMonths;
    protected $periodeTahun;
    protected $pci;

    public function __construct($months = null, $year = null, $pci = null)
    {
        $this->periodeTahun = $year ?? Carbon::now()->year;
        $this->periodeMonths = $months ?? Carbon::now()->month;
        $this->pci = $pci;
    }

    public function generatePDF()
    {
        // Query data for the selected period
        $projects = Project::with(['users', 'member'])
            ->whereYear('start', $this->periodeTahun)
            ->whereMonth('start', $this->periodeMonths)
            ->when($this->pci, function($query) {
                return $query->where('pm', $this->pci);
            })
            ->get();

        // Prepare date strings for the period
        $periode = '1 - ' . Carbon::create($this->periodeTahun, $this->periodeMonths, 1)
            ->endOfMonth()
            ->translatedFormat('d') . ' ' .
            Carbon::create($this->periodeTahun, $this->periodeMonths, 1)
                ->locale('id')
                ->translatedFormat('F Y');

        $periodeTitle = Carbon::create($this->periodeTahun, $this->periodeMonths, 1)
            ->locale('id')
            ->translatedFormat('F Y');

        // Data to be passed to the view
        $data = [
            'project' => $projects,
            'periode' => $periode,
            'periodeTitle' => $periodeTitle,
        ];

        // Generate PDF
        $pdf = Pdf::loadView('reports.reports_proyek_bulan', $data);

        // Return PDF
        return $pdf->download('laporan_proyek_periode_' . $periodeTitle . '.pdf');
    }
}
