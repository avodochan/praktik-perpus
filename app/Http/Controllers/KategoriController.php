<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = Kategori::all();
        return view('admin.kategori.index', compact('kategori'));
    }
    public function koordinatorview()
    {
        $kategori = Kategori::all();
        return view('koordinator.kategori.index', compact('kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        $user = auth()->user();
        if ($user->role == 'koordinator') {
            $kategori = Kategori::all();
            return redirect()->route('koordinator.kategori.view')
                ->with('success', 'Kategori berhasil ditambahkan.');
        } elseif ($user->role == 'admin') {
            $kategori = Kategori::all();
            return redirect()->route('admin.kategori.view')
                ->with('success', 'Kategori berhasil ditambahkan.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(kategori $kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(kategori $kategori)
    {
        return view('admin.kategori.edit',compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, kategori $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategori->update($request->all());
        $user = auth()->user();
        if ($user->role == 'koordinator') {
            $kategori = Kategori::all();
            return redirect()->route('koordinator.kategori.view')
                ->with('success', 'Kategori berhasil diperbarui.');
        } elseif ($user->role == 'admin') {
            $kategori = Kategori::all();
            return redirect()->route('admin.kategori.view')
                ->with('success', 'Kategori berhasil diperbarui.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(kategori $kategori)
    {
        $kategori->delete();
        $user = auth()->user();
        if ($user->role == 'koordinator') {
            $kategori = Kategori::all();
            return redirect()->route('koordinator.kategori.view')
                ->with('success', 'Kategori berhasil dihapus.');
        } elseif ($user->role == 'admin') {
            $kategori = Kategori::all();
            return redirect()->route('admin.kategori.view')
                ->with('success', 'Kategori berhasil dihapus.');
        }
    }
}
