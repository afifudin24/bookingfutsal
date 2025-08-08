<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use PDF; // Import Barryvdh\DomPDF\Facade
use Barryvdh\DomPDF\Facade\Pdf; // Import tanpa alias
use App\Models\Laporan;
use Illuminate\Support\Facades\DB;

class PDFController extends Controller
{
    public function cetakLaporan(Request $request)
    {
        // gunakan pengecekan jika ada filterasi berdasarkan tanggal
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if (empty($start_date && $end_date)) {
            $laporan = Laporan::all();
            $data = Laporan::all()->first();
            $pdf = PDF::loadview('laporan.rekap', compact('laporan', 'data'));
            return $pdf->download('laporan.pdf');
        } else {
            $laporan = Laporan::whereBetween(DB::raw('DATE(tanggal_konfirmasi)'), [$start_date, $end_date])->get();
            $data = Laporan::all()->first();
            $pdf = PDF::loadview('laporan.rekap', compact('laporan', 'data'));
            return $pdf->download('laporan.pdf');
        }


    }
}
