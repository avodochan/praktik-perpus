<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use App\Models\Member;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class DendaController extends Controller //nama class
{
    /**
     * Display a listing of the resource.
     */
    
    //menampilkan halaman denda
    public function index()//index adalah method
    {
        $denda = Denda::all();
        return view('admin.denda.index', compact('denda')); //compact adalah function
    }

    //method untuk role koordinator
    public function koordinatorview()
    {
        $denda = Denda::all();
        return view('koordinator.denda.index', compact('denda'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $member = Member::all(); //get data member dari table member
        $peminjaman = Peminjaman::all(); //get data peminjaman
        return view ('admin.denda.create', compact('member', 'peminjaman'));
    }

    /**
     * Store a newly created resource in storage.
     */
    
    //menyimpan denda ke tabel denda
    public function store(Request $request)
    {
        //request adalah objek
        //validate untuk memvalidasi inputan
        //exists berarti sudah ada di tabel (nama tabel), (nama kolom)
        //numeric berarti hanya bisa diinputkan angka saja
        $request->validate([
            'id_pinjem' => 'required|exists:peminjaman,id_pinjem',
            'jenis_denda' => 'required',
            'besar_denda' => 'required|numeric',
        ]);
        //membuat denda dari objek requesr
        Denda::create([
            'id_pinjem' => $request->id_pinjem,
            'jenis_denda' => $request->jenis_denda,
            'besar_denda' => $request->besar_denda,
        ]);
        
        $user = auth()->user(); //cek user yang sedang login
        //jika role koordinator
        if ($user->role == 'koordinator') 
        {
            $denda = Denda::all(); //get data denda
            return redirect()->route('koordinator.denda.view')->with('success', 'Denda berhasil ditambahkan.'); //redirect ke route koordinator.denda.view(sudah didefinisikan di web.php) dengan keterangannya
        } 
        //jika role admin
        elseif ($user->role == 'admin') 
        {
            $denda = Denda::all();
            return redirect()->route('admin.denda.view')->with('success', 'Denda berhasil ditambahkan.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(denda $denda)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    
    public function edit(Denda $denda)
    {
        $member = Member::all(); //get data member
        $peminjaman = Peminjaman::all(); //get peminjaman
        return view('admin.denda.edit', compact('denda', 'member', 'peminjaman'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Denda $denda)
    {
        $request->validate([
            'id_pinjem' => 'required|exists:peminjaman,id_pinjem',
            'jenis_denda' => 'required',
            'besar_denda' => 'required|numeric',
        ]);
        //update data denda dari objek request
        $denda->update( $request->all());
        $user = auth()->user();
        if ($user->role == 'koordinator') 
        {
            $denda = Denda::all();
            return redirect()->route('koordinator.denda.view') ->with('success', 'Denda berhasil diperbarui.');
        }
        elseif ($user->role == 'admin') 
        {
            $denda = Denda::all();
            return redirect()->route('admin.denda.view')->with('success', 'Denda berhasil diperbarui.');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Denda $denda)
    {
        $denda->delete(); //delete adalah function

        $user = auth()->user();
        if ($user->role == 'koordinator') 
        {
            $denda = Denda::all();
            return redirect()->route('koordinator.denda.view')->with('success', 'Denda berhasil dihapus.');
        } 
        elseif ($user->role == 'admin') 
        {
            $denda = Denda::all();
            return redirect()->route('admin.denda.view')->with('success', 'Denda berhasil dihapus.');
        }
    }
}
