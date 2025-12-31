<?php

namespace App\Exports\Excel;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Contracts\View\View;
use Carbon\Carbon;

// Models
use App\Models\Master\Project;

class LaporanProyekPeriode implements FromView, WithColumnWidths
{

    protected $periodeMonths;
    protected $periodeTahun;
    protected $pci;

    public function __construct($months = null , $year = null, $pci = null){
        $this->periodeTahun = $year ?? Carbon::now()->year;
        $this->periodeMonths = $months  ?? Carbon::now()->month;
        $this->pci = $pci;
    }

    public function view(): View
    {
        //$users = User::all(); // Ambil data yang ingin ditampilkan di Excel
        $data = [];
        $data['project'] = Project::with(['users','member'])        
        ->whereYear('start',$this->periodeTahun)
        ->whereMonth('start',$this->periodeMonths)
        ->when($this->pci, function($query) {
            return $query->where('pm', $this->pci);
        })
        ->get();        

        $data['periode'] = '1 - ' . Carbon::now()->year($this->periodeTahun)->month($this->periodeMonths)->endOfMonth()->translatedFormat('d'). ' ' . Carbon::now()->year($this->periodeTahun)->month($this->periodeMonths)->locale('id')->translatedFormat('F Y');

        $data['periodeTitle'] = Carbon::now()->year($this->periodeTahun)->month($this->periodeMonths)->locale('id')->translatedFormat('F Y');

        return view('reports.reports_proyek_bulan', $data); // Mengembalikan view yang telah kita buat
    }
    
    public function columnWidths(): array
    {
        return [
            'A' => 8,   // No
            'B' => 18,  // Nama Proyek
            'C' => 35,  // Deskripsi Proyek
            'D' => 25,  // Tanggal Mulai
            'E' => 25,  // Tanggal Selesai
            'F' => 15,  // Status
            'G' => 18,  // PIC
        ];
    }
}
