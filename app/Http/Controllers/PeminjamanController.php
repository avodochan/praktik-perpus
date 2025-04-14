<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $peminjaman = Peminjaman::all();
        return view('admin.peminjaman.index', compact('peminjaman'));
    }
    
    public function koordinatorview()
    {
        $peminjaman = Peminjaman::all();
        return view('koordinator.peminjaman.index', compact('peminjaman'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $buku = Buku::select('id_buku', 'judul')->get();
        $members = Member::select('id_member', 'nama')->get();
        return view('admin.peminjaman.create', compact('buku', 'members'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_buku' => 'required|exists:buku,id_buku',
            'id_member' => 'required|exists:member,id_member',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'nullable|date|after:tgl_pinjam',
        ]);

        Peminjaman::create($request->all());
        
        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Peminjaman $peminjaman)
    {
        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Peminjaman $peminjaman)
    {
        $buku = Buku::select('id_buku', 'judul')->get();
        $members = Member::select('id_member', 'nama')->get();
        $peminjaman->tgl_pinjam = Carbon::parse($peminjaman->tgl_pinjam)->format('Y-m-d');
        $peminjaman->tgl_kembali = Carbon::parse($peminjaman->tgl_kembali)->format('Y-m-d');
        return view('admin.peminjaman.edit', compact('peminjaman', 'buku', 'members'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'id_buku' => 'required|exists:buku,id_buku',
            'id_member' => 'required|exists:member,id_member',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'required|date|after:tgl_pinjam',
        ]);

        $peminjaman->update( $request->all());
        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->delete();
        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dihapus.');
    }
    
    public function exportPDF(Request $request)
    {
        $request->validate([
            'periodeawal'=>'required|date',
            'periodeakhir'=>'required|date',
        ]);
        
        
        $data = Peminjaman::whereBetween('tgl_pinjam', [$request->periodeawal, $request->periodeakhir])->get();
        $pdf = Pdf::loadView('koordinator.pdf.template', compact('data'));
        return $pdf->download('peminjaman.pdf');
        
    }
}
