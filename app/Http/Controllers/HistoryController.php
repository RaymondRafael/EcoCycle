<?php

namespace App\Http\Controllers;

use App\Models\Pickup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        // Mengambil riwayat pickup milik user yang sedang login
        // Diurutkan dari tanggal penjemputan terbaru (descending)
        $pickups = Pickup::where('user_id', Auth::id())
                         ->orderBy('pickup_date', 'desc')
                         ->get();

        // Mengirim data $pickups ke view history.index
        return view('history.index', compact('pickups'));
    }
}