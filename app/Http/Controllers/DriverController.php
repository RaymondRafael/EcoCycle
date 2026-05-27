<?php

namespace App\Http\Controllers;

use App\Models\Pickup;
use App\Models\PickupDetail;
use App\Models\WasteCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DriverController extends Controller
{
    public function index()
    {
        $driverId = Auth::id();

        $myPickups = Pickup::with('user')
            ->where('driver_id', $driverId)
            ->whereIn('status', ['pending', 'on_the_way'])
            ->orderBy('pickup_date', 'asc')
            ->get();

        $availablePickups = Pickup::with('user')
            ->whereNull('driver_id')
            ->where('status', 'pending')
            ->orderBy('pickup_date', 'asc')
            ->get();

        return view('driver.dashboard', compact('myPickups', 'availablePickups'));
    }

    public function claim($id)
    {
        $pickup = Pickup::findOrFail($id);

        if ($pickup->driver_id !== null) {
            return back()->with('error', 'Penjemputan ini sudah diambil oleh driver lain.');
        }

        $pickup->update([
            'driver_id' => Auth::id(),
            'status' => 'pending'
        ]);

        return redirect()->route('driver.detail', $pickup->id)->with('success', 'Tugas penjemputan berhasil diambil!');
    }

    public function start($id)
    {
        $pickup = Pickup::where('id', $id)->where('driver_id', Auth::id())->firstOrFail();
        
        $pickup->update([
            'status' => 'on_the_way'
        ]);

        return back()->with('success', 'Status diperbarui: Anda sedang menuju ke lokasi!');
    }

    public function detail($id)
    {
        $pickup = Pickup::with(['user', 'details.wasteCategory'])->where('id', $id)->firstOrFail();
        
        if ($pickup->driver_id !== null && $pickup->driver_id !== Auth::id()) {
            abort(403, 'Akses Ditolak. Tugas ini bukan milik Anda.');
        }

        $categories = WasteCategory::all();

        return view('driver.detail', compact('pickup', 'categories'));
    }

    public function verify(Request $request, $id)
    {
        $pickup = Pickup::where('id', $id)->where('driver_id', Auth::id())->firstOrFail();

        $request->validate([
            'weights' => 'required|array',
            'weights.*' => 'nullable|numeric|min:0',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'driver_notes' => 'nullable|string',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = 'pickup_' . $pickup->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/pickups'), $filename);
            $photoPath = 'uploads/pickups/' . $filename;
        }

        $totalPoints = 0;
        
        $pickup->details()->delete();

        foreach ($request->weights as $categoryId => $weight) {
            if ($weight > 0) {
                $category = WasteCategory::findOrFail($categoryId);
                
                $rate = ($pickup->user->role === 'b2b_user') ? $category->price_to_factory_per_kg : $category->point_reward_per_kg;
                $subtotal = round($weight * $rate);

                PickupDetail::create([
                    'pickup_id' => $pickup->id,
                    'waste_category_id' => $categoryId,
                    'weight_kg' => $weight,
                    'subtotal_points' => $subtotal
                ]);

                $totalPoints += $subtotal;
            }
        }

        if ($totalPoints === 0) {
            return back()->withInput()->with('error', 'Anda harus memasukkan berat minimal untuk salah satu kategori sampah.');
        }

        $pickup->update([
            'status' => 'completed',
            'total_points_earned' => $totalPoints,
            'photo' => $photoPath,
            'driver_notes' => $request->driver_notes
        ]);

        $pickup->user->increment('point_balance', $totalPoints);

        return redirect()->route('driver.dashboard')->with('success', 'Penjemputan berhasil diselesaikan! Poin sebesar ' . number_format($totalPoints) . ' telah dikirim ke pelanggan.');
    }

    public function reportIssue(Request $request, $id)
    {
        $pickup = Pickup::where('id', $id)->where('driver_id', Auth::id())->firstOrFail();

        $request->validate([
            'reason' => 'required|string|min:10',
        ]);

        $pickup->update([
            'status' => 'cancelled',
            'driver_notes' => 'KENDALA LAPANGAN: ' . $request->reason
        ]);

        return redirect()->route('driver.dashboard')->with('success', 'Kendala lapangan telah dilaporkan. Status penjemputan diubah menjadi Cancelled.');
    }

    public function history()
    {
        $driverId = Auth::id();

        $history = Pickup::with('user')
            ->where('driver_id', $driverId)
            ->whereIn('status', ['completed', 'cancelled'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('driver.history', compact('history'));
    }
}
