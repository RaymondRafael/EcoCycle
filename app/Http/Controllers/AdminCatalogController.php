<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use Illuminate\Http\Request;

class AdminCatalogController extends Controller
{
    // Menampilkan halaman katalog
    public function index()
    {
        $catalogs = Catalog::orderBy('created_at', 'desc')->get();
        return view('admin.catalogs.index', compact('catalogs'));
    }

    // Menambah kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'icon_class' => 'required|string|max:50',
            'color_class' => 'required|string|max:50',
            'price_b2c' => 'required|integer|min:0',
            'price_b2b' => 'required|integer|min:0',
        ]);

        Catalog::create([
            'name' => $request->name,
            'description' => $request->description,
            'icon_class' => $request->icon_class,
            'color_class' => $request->color_class,
            'price_b2c' => $request->price_b2c,
            'price_b2b' => $request->price_b2b,
        ]);

        return back()->with('success', 'Kategori limbah baru berhasil ditambahkan!');
    }

    // Mengubah harga/data (Update Inline)
    public function update(Request $request, $id)
    {
        $catalog = Catalog::findOrFail($id);
        
        $catalog->update([
            'price_b2c' => $request->price_b2c,
            'price_b2b' => $request->price_b2b,
        ]);

        return back()->with('success', 'Harga katalog berhasil diperbarui!');
    }

    // Menghapus kategori
    public function destroy($id)
    {
        Catalog::findOrFail($id)->delete();
        return back()->with('success', 'Kategori sampah berhasil dihapus.');
    }
}