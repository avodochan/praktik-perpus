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
        $peminjaman = Peminjaman::all(); //get data peminjaman yang ada di database
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
        $members = Member::select('id_member', 'nama')->get(); //menampilkan nama member dari tabel member untuk keperluan mengisi form
        return view('admin.peminjaman.create', compact('buku', 'members'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validasi untuk mengisi tabel peminjaman
        //required berarti field di form tersebut harus diisi
        //exists berarti ada di dalam tabel (nama tabel) dan di kolom (nama kolom)
        //after sebagai validasi bahwa tgl_kembali harus tanggal setelah tgl_pinjam
        $request->validate([
            'id_buku' => 'required|exists:buku,id_buku',
            'id_member' => 'required|exists:member,id_member',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'nullable|date|after:tgl_pinjam',
        ]);

        // menghitung tanggal kembali seharusnya di hardcode H+7 dari tgl_pinjam tapi tidak disimpan ke database
        $tgl_kembali_seharusnya = Carbon::parse($request->tgl_pinjam)->addDays(7);

        //mengirim data yang sudah diisi ke database
        Peminjaman::create($request->all());

        $user = auth()->user(); //mengecek user mana yang login
        //jika yang login adalah role koordinator
        if ($user->role == 'koordinator') 
        {
            return redirect()->route('koordinator.peminjaman.view') //setelah mengirim data maka role koordinator akan mengarah ke route koordinator.peminjaman.view
                ->with('success', 'Peminjaman berhasil ditambahkan'); //dengan validasi sukses dan keterangannya
        } 
        //jika yang login adalah role admin
        elseif ($user->role == 'admin') 
        {
            return redirect()->route('admin.peminjaman.view') //setelah mengirim data maka role admin akan mengarah ke route admin.peminjaman.view
                ->with('success', 'Peminjaman berhasil ditambahkan' ); //dengan validasi sukses dan keterangannya
        }
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
        $buku = Buku::select('id_buku', 'judul')->get(); //mengambil judul buku dari tabel buku
        $members = Member::select('id_member', 'nama')->get(); //mengambil nama member dari tabel member
        return view('admin.peminjaman.edit', compact('peminjaman', 'buku', 'members'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peminjaman $peminjaman)
    {
        //objek request
        //validasi form yang diisi
        //required berarti harus diisi
        //exists berarti sebelumnya sudah ada di tabel (nama tabel) dan kolom (nama kolom)
        //after_or_equal di tgl_kembali berarti tgl_kembali harus setelah atau sama dengan tgl_pinjam
        $request->validate([
            'id_buku' => 'required|exists:buku,id_buku',
            'id_member' => 'required|exists:member,id_member',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_pinjam',
        ]);

        // jika tgl_kembali kosong, set default dengan tanggal hari ini
        if (!$request->tgl_kembali) 
        {
            $request->merge(['tgl_kembali' => Carbon::now()->format('Y-m-d')]);
        }

        //update seluruh data peminjaman yang sudah ada di objek request
        $peminjaman->update($request->all());
        
        //menghitung tgl_kembali_seharusnya dengan di hardcode H+7 dari tgl_pinjam tapi tidak disimpan ke database dengan format d-m-Y
        $tgl_kembali_seharusnya = Carbon::parse($peminjaman->tgl_pinjam)->addDays(7)->format('d-m-Y');

        //cek user yang login
        $user = auth()->user();
        //jika user yang login adalah koordinator
        if ($user->role == 'koordinator') 
        {
            return redirect()->route('koordinator.peminjaman.view') //setelah data berhasil diupdate maka akan mengarah ke route koordinator.peminjaman.view
                ->with('success', 'Peminjaman berhasil diperbarui'); //dengan validasi sukses dan keterangannya
        }
        //jika yang login adalah admin 
        elseif ($user->role == 'admin') 
        {
            return redirect()->route('admin.peminjaman.view') //setelah data berhasil diupdate maka akan mengarah ke route admin.peminjaman.view
                ->with('success', 'Peminjaman berhasil diperbarui' ); //dengan validasi sukses dan keterangannya
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peminjaman $peminjaman)
    {
        //menghapus data di database
        $peminjaman->delete();
        
        //mengecek user yang login
        $user = auth()->user();
        //jika yang login adalah koordinator
        if ($user->role == 'koordinator') 
        {
            $peminjaman = Peminjaman::all();
            return redirect()->route('koordinator.peminjaman.view') //setelah data berhasil dihapus maka akan mengarah ke route koordinator.peminjaman.view
                ->with('success', 'Peminjaman berhasil dihapus.'); //dengan validasi sukses dan keterangannya
        }
        //jika yang login adalah admin 
        elseif ($user->role == 'admin') 
        {
            $peminjaman = Peminjaman::all();
            return redirect()->route('admin.peminjaman.view') //setelah data berhasil dihapus maka akan mengarah ke route koordinator.peminjaman.view
                ->with('success', 'Peminjaman berhasil dihapus.'); //dengan validasi sukses dan keterangannya
        }    
    }
    
    //method untuk export laporan ke pdf
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
