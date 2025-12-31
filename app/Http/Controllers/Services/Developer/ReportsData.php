<?php

namespace App\Http\Controllers\Services\Developer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\PDF\ReportDetailLogging;

class ReportsData extends Controller
{
    public function reportDetailLogging(Request $req){
        $id = $req->input('id');
        if (!$id) {
            abort(404);
        }
        $pdf = new ReportDetailLogging($id);
        return $pdf->generatePDF();

    }
}
