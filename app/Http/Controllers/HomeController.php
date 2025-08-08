<?php

namespace App\Http\Controllers;



use App\Models\Lapangan;
use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $booking = Booking::all();

        return view('landing.index', compact('booking'));
    }
    public function jadwal(Request $request)
    {
        $booking = Booking::with('lapangan')->where('status', 'Masuk Jadwal')
            ->orWhere('status', 'Lunas')
            ->get();
        $lapangan = Lapangan::all();
        // dd($booking);
        return view('landing.index', compact('booking', 'lapangan'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminHome()
    {
        return view('admin.index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function managerHome()
    {
        return view('managerHome');
    }
}
