<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;


class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buku = Buku::with('kategori')->get();
        return view('admin.buku.index', compact('buku'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = Kategori::all();
        return view('admin.buku.create', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_buku' => 'required|unique:buku,id_buku',
            'id_kategori' => 'required',
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'stok' => 'required|integer',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'sinopsis' => 'required',
        ]);

        $data = $request->all();
        if ($request->hasFile('cover')) {
            $filePath = $request->file('cover')->store('covers', 'public');
            $data['cover'] = $filePath; 
        }

        Buku::create($data);
        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan!');
    }


    /**
     * Display the specified resource.
     */
    public function show(buku $buku, $id_buku)
    {
        $buku = Buku::with('kategori')->find($id_buku);

        if (!$buku) {
            return response()->json(['status' => 'error', 'message' => 'Buku tidak ditemukan'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $buku]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(buku $buku, $id_buku)
    {
        $buku = Buku::findOrFail($id_buku);
        $kategori = Kategori::all();
        return view('admin.buku.edit', compact('buku', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, buku $buku, $id_buku)
    {
        $buku = Buku::find($id_buku);

        if (!$buku) {
            return response()->json(['status' => 'error', 'message' => 'Buku tidak ditemukan'], 404);
        }

        $request->validate([
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'cover' => 'nullable|string',
            'sinopsis' => 'required|string',
        ]);

        $buku->update($request->all());

        return response()->json(['status' => 'success', 'message' => 'Buku berhasil diperbarui', 'data' => $buku]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(buku $buku, $id_buku)
    {
        $buku = Buku::find($id_buku);

        if (!$buku) {
            return response()->json(['status' => 'error', 'message' => 'Buku tidak ditemukan']);
        }

        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus!');    }
}
