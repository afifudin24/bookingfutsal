<?php

namespace App\Http\Controllers;


use App\Models\Lapangan;
use App\Models\Booking;
use App\Models\User;
use App\Models\Laporan;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class BookingAdminController extends Controller
{
    public function index(Request $request)
    {
      $booking = Booking::whereIn('pembayaraan', ['Bayar DP', 'Bayar Lunas'])->get();

        $data = Booking::all()->first();
        $pembayaran = 'Online';
        return view('bookingadmin.index', compact('booking', 'data', 'pembayaran'));
    }
    public function indexoffline(Request $request)
    {
        $booking = Booking::where('pembayaraan', 'Cash Lunas')
            ->get();
        $data = Booking::all()->first();
        $pembayaran = 'Offline';
        return view('bookingadmin.index', compact('booking', 'data', 'pembayaran'));
    }
    public function indexpemilik(Request $request)
    {
        $booking = Booking::where('pembayaraan', 'Bayar Lunas')
            ->get();
        $data = Booking::all()->first();
        return view('pemilik.index', compact('booking', 'data'));
    }
    public function createOffline()
    {
        $lapangan = Lapangan::all();
        $data = Lapangan::first();
        $allLapangan = Lapangan::all();
        return view('bookingadmin.createOffline', compact('lapangan', 'data'));
    }
    public function indexpemilikoffline(Request $request)
    {
        $booking = Booking::where('pembayaraan', 'Cash Lunas')
            ->get();
        $data = Booking::all()->first();
        return view('pemilik.index_offline', compact('booking', 'data'));
    }
    public function filter(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $pembayaran = $request->pembayaran;
        if (empty($start_date && $end_date)) {
            if ($pembayaran == 'Offline') {
                $booking = Booking::where('pembayaraan', 'Cash Lunas')->get();
                // $booking = Booking::where('');
            } else {
                $booking = Booking::where('pembayaraan', 'Bayar Lunas')->get();
            }
            $data = Booking::all()->first();
            return view('bookingadmin.index', compact('booking', 'data', 'pembayaran'));
        } else {
            if ($pembayaran == 'Offline') {
                $booking = Booking::whereBetween(DB::raw('DATE(time_from)'), [$start_date, $end_date])->where('pembayaraan', 'Cash Lunas')->get();
            } else {
                $booking = Booking::whereBetween(DB::raw('DATE(time_from)'), [$start_date, $end_date])->where('pembayaraan', 'Bayar Lunas')->get();
            }

            $data = Booking::all()->first();
            return view('bookingadmin.index', compact('booking', 'data', 'pembayaran'));
        }
    }
    public function jadwal(Request $request)
    {
        $booking = Booking::where('status', 'Masuk Jadwal')
            ->orWhere('status', 'Selesai')
            ->get();
        $lapangan = Lapangan::all();
        $data = Lapangan::all('harga', 'status')->first();
        return view('jadwal.index', compact('booking', 'lapangan', 'data'));
    }
    public function show($id)
    {
        $booking = Booking::findOrfail($id);
        $lapangan = Lapangan::all();
        $orderDate = Booking::findOrfail($id)->created_at;
        $paymentDue = (new \DateTime($orderDate))->modify('+1 hour')->format('Y-m-d H:i:s');
        return view('booking.show', compact('booking', 'lapangan', 'paymentDue'));
    }
    public function edit(Booking $booking)
    {
        $lapangan = Lapangan::all();

        return view('bookingadmin.create', compact('booking', 'lapangan'));
    }
    public function update(Booking $booking, Request $request)
    {
        $rules =
            [
                // 'time_from' => 'required',
                // 'time_to' => 'required',
                'status' => 'required',
            ];
        $this->validate($request, $rules);

        $jam = Carbon::parse($request->time_from)->diffInHours(Carbon::parse($request->time_to));
        $booking->update([
            'status' => $request['status'],
        ]);
        return redirect('/bookingadmin/index');
    }
    public function destroy($id)
    {
        $data = Booking::find($id);
        $data->delete();
        return redirect('/bookingadmin/index')->with('success', 'Data Berhasil Dihapus');
    }
    public function konfirmasi(Booking $id, Request $request)
    {
        $data = Booking::find($request->id);
        $data->status = $request->status;
        if ($request->status == 'Selesai') {
            $laporan = new Laporan();
            // tanggal konfirmasi gunakan tanggal sekarang
            $laporan->tanggal_konfirmasi = date('Y-m-d');
            $laporan->cara_bayar = $data->pembayaraan;
            $laporan->total_harga = $data->total_harga;
            $laporan->save();
        }
        $data->save();
        return redirect('/bookingadmin/index');
    }
}
