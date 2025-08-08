<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
class FeedbackController extends Controller
{
    public function index()
    {
        if (auth()->user()->type == 'admin') {
            $feedback = Feedback::with('user')->get();
        
            return view('feedback.index', compact('feedback'));
        } else if (auth()->user()->type == 'user') {
            return view('feedback.create');
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'feedback' => 'required',
        ]);
        $feedback = new Feedback();
        $feedback->user_id = auth()->user()->id;
        // tanggal feedback menggunakan tanggal terkini
        $feedback->tanggal_feedback = date('Y-m-d');
        $feedback->feedback = $request->feedback;
        $feedback->save();
        return redirect()->back()->with('success', 'Feedback berhasil terkirim');
    }

    public function destroy($id)
    {
        $feedback = Feedback::find($id);
        $feedback->delete();
        return redirect()->back()->with('success', 'Feedback berhasil dihapus');
    }
}
