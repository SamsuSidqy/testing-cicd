<?php

namespace App\Exports\PDF;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Developer\Logging;

class ReportDetailLogging
{
    protected $id;

    public function __construct($id){
        $this->id = $id;
    }

    public function generatePDF(){
        $result = Logging::with('pengguna')->where('id_logging',$this->id)->first();
        $data = [];
        $data['payload'] = $result;
        // return view('reports.developer.logs_detail', $data);
        $pdf = Pdf::loadView('reports.developer.logs_detail', $data);
        return $pdf->download('log'.$result->pengguna->name.'.pdf');
    }
}
