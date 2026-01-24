<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::with('kategori')->latest()->paginate(10);
        return view('menu.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        return view('menu.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_menu' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id_kategori',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $path = 'fotos/default.jpg';
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('fotos', 'public');
        }

        Menu::create([
            'nama_menu' => $validatedData['nama_menu'],
            'kategori_id' => $validatedData['kategori_id'],
            'harga' => $validatedData['harga'],
            'deskripsi' => $validatedData['deskripsi'],
            'stok' => $validatedData['stok'],
            'is_available' => $validatedData['stok'] > 0,
            'foto' => $path,
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        // Logic to show a single menu will be here
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        $kategoris = Kategori::all();
        return view('menu.edit', compact('menu', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        $validatedData = $request->validate([
            'nama_menu' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id_kategori',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $updateData = $validatedData;
        
        $updateData['is_available'] = $validatedData['stok'] > 0;

        if ($request->hasFile('foto')) {
            if ($menu->foto && $menu->foto !== 'fotos/default.jpg') {
                Storage::disk('public')->delete($menu->foto);
            }
            $updateData['foto'] = $request->file('foto')->store('fotos', 'public');
        }

        $menu->update($updateData);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        // Hapus foto dari storage jika bukan foto default
        if ($menu->foto && $menu->foto !== 'fotos/default.jpg') {
            Storage::disk('public')->delete($menu->foto);
        }

        $menu->delete();

        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus!');
    }
}
