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
    public function index()//index adalah method
    {
        //mengambil data dari tabel buku
        //setelah data diambil maka akan mengarah ke view buku.index dan menampilkan data buku
        $buku = Buku::with('kategori')->get();
        return view('admin.buku.index', compact('buku')); //compact adalah function untuk membuat array dari variable
    }
    
    //method untuk role koordinator
    public function koordinatorview()
    {
        $buku = Buku::with('kategori')->get();
        return view('koordinator.buku.index', compact('buku'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //mengambil data dari tabel kategori
        //setelah data diambil maka akan mengarah ke view buku.create dan menampilkan data
        $kategori = Kategori::all();
        return view('admin.buku.create', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validasi agar semua form wajib diisi (kecuali field cover)
        //request adalah objek
        $request->validate([
            'id_kategori' => 'required',
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'stok' => 'required|integer',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'sinopsis' => 'required',
        ]);
        
        //menyimpan semua input yang ada sudah di validasi di objek $data
        $data = $request->all();
        //jika user mmenambahkan cover, maka foto akan masuk ke folder public -> cover
        if ($request->hasFile('cover')) 
        {
            $filePath = $request->file('cover')->store('covers', 'public');
            $data['cover'] = $filePath; 
        }
        
        //menyimpan input yang ada di objek $data ke dalam table
        Buku::create($data);
        $user = auth()->user(); //mengecek user mana yang sedang login
        //jika user role adalah koordinator
        if ($user->role == 'koordinator') 
        {
            $buku = Buku::all(); //get semua data buku
            return redirect()->route('koordinator.buku.view')->with('success', 'Buku berhasil ditambahkan.'); //redirect ke route koordinator.buku.view (sudah didefinisikan di web.php) dengan keterangannya
        } 
        //jika user role adalah admin
        elseif ($user->role == 'admin') 
        {
            $buku = Buku::all(); //get semua data buku
            return redirect()->route('admin.buku.view')->with('success', 'Buku berhasil ditambahkan.'); //redirect ke route koordinator.buku.view (sudah didefinisikan di web.php) dengan keterangannya
        }
    }


    /**
     * Display the specified resource.
     */
    
    public function show(buku $buku, $id_buku)
    {
        //menampilkan buku dengan kategori
        $buku = Buku::with('kategori')->find($id_buku);

        //jika tidak ada buku
        if (!$buku) 
        {
            return response()->json(['status' => 'error', 'message' => 'Buku tidak ditemukan'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $buku]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(buku $buku)
    {   
        $kategori = Kategori::all();
        return view ('admin.buku.edit', compact('buku', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, buku $buku)
    {
        //validasi untuk isi form
        //exists berarti sudah ada di tabel (nama tabel), (nama kolom)
        //nullable berarti opsional (tidak wajib diisi)
        $request->validate([
            'id_kategori' => 'required|exists:kategori,id',
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'cover' => 'nullable|string',
            'sinopsis' => 'required|string',
        ]);

        //update semua data
        $buku->update($request->all());
        $user = auth()->user(); //cek user yang login
        //jika user role adalah koordinator
        if ($user->role == 'koordinator') 
        {
            $buku = Buku::all(); //get semya data buku
            return redirect()->route('koordinator.buku.view')->with('success', 'Buku berhasil diperbarui.'); //redirect ke route koordinator.buku.view dengan keterangannya
        } 
        //jika user role adalah admin
        elseif ($user->role == 'admin') 
        {
            $buku = Buku::all();
            return redirect()->route('admin.buku.view')->with('success', 'Buku berhasil diperbarui.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(buku $buku)
    {
        $buku->delete(); //delete adalah function untuk menghapus buku
        $user = auth()->user();
        
        if ($user->role == 'koordinator') 
        {
            $buku = Buku::all();
            return redirect()->route('koordinator.buku.view')->with('success', 'Buku berhasil dihapus.');
        } 
        elseif ($user->role == 'admin') 
        {
            $buku = Buku::all();
            return redirect()->route('admin.buku.view')->with('success', 'Buku berhasil dihapus.');
        }
    }
}
