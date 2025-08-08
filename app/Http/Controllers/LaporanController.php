<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // $laporan = Laporan::all();
        // terapkan pengecekan tanggal filter awal dan akhir
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if (empty($start_date && $end_date)) {
            $laporan = Laporan::all();
            $data = Laporan::all()->first();
            return view('laporan.index', compact('laporan', 'data'));
        } else {
            $laporan = Laporan::whereBetween('tanggal_konfirmasi', [$start_date, $end_date])->get();
            $data = Laporan::all()->first();
            return view('laporan.index', compact('laporan', 'data'));
        }
    }
}
