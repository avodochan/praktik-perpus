<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use App\Models\Member;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class DendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $denda = Denda::all();
        return view('admin.denda.index', compact('denda'));
    }

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
        $member = Member::all();
        $peminjaman = Peminjaman::all();
        return view ('admin.denda.create', compact('member', 'peminjaman'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_pinjem' => 'required|exists:peminjaman,id_pinjem',
            'jenis_denda' => 'required',
            'besar_denda' => 'required|numeric',
        ]);
        Denda::create([
            'id_pinjem' => $request->id_pinjem,
            'jenis_denda' => $request->jenis_denda,
            'besar_denda' => $request->besar_denda,
        ]);
        $user = auth()->user();
        if($user->role =='koordinator')
        {
            $denda = Denda::all();
            return view('koordinator.denda.index', compact ('denda'))->with('success', 'Data denda berhasil ditambahkan');
        }
        elseif($user->role =='admin')
        {
            $denda = Denda::all();
            return view('admin.denda.index', compact ('denda'))->with('success', 'Data denda berhasil ditambahkan');
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
        $member = Member::all();
        $peminjaman = Peminjaman::all();
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
        $denda->update( $request->all());
        
        return redirect()->route('denda.index')->with('success', 'Denda berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Denda $denda)
    {
        $denda->delete();

        return redirect()->route('denda.index')->with('success', 'Denda berhasil dihapus');
    }
}
