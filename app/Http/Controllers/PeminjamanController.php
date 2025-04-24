<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\Member;
use App\Models\Denda;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()//index adalah method
    { 
        $peminjaman = Peminjaman::with(['buku', 'member'])->get(); //peminjaman adalah objek
        return view('admin.peminjaman.index', compact('peminjaman')); //compact adalah function untuk membuat array dari variable
    }
    
    public function koordinatorview()
    {
        $peminjaman = Peminjaman::with(['buku', 'member'])->get();
        return view('koordinator.peminjaman.index', compact('peminjaman'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()//create adalah method
    {
        $buku = Buku::select('id_buku', 'judul')->get(); //buku adalah objek
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
            'tgl_kembali_seharusnya' => 'nullable|date|after:tgl_pinjam',
        ]);

        //mengambil data tgl_lkembali_seharusnya dari objek request
        $tgl_kembali_seharusnya = Carbon::parse($request->tgl_kembali_seharusnya)->format('Y-m-d');
        
        //menambagkan tgl_kembali_seharusnya ke objek request
        $request->merge(['tgl_kembali_seharusnya' => $tgl_kembali_seharusnya]);

        //mengirim data yang sudah diisi ke database
        Peminjaman::create($request->all());

        $user = auth()->user(); //mengecek user mana yang login
        //jika yang login adalah role koordinator
        if ($user->role == 'koordinator') 
        {
            return redirect()->route('koordinator.peminjaman.view') //setelah mengirim data maka role koordinator akan mengarah ke route koordinator.peminjaman.view
                ->with('success', 'Peminjaman berhasil ditambahkan.'); //dengan validasi sukses dan keterangannya
        } 
        //jika yang login adalah role admin
        elseif ($user->role == 'admin') 
        {
            return redirect()->route('admin.peminjaman.view') //setelah mengirim data maka role admin akan mengarah ke route admin.peminjaman.view
                ->with('success', 'Peminjaman berhasil ditambahkan.'); //dengan validasi sukses dan keterangannya
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
    
    public function update(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'id_buku' => 'required|exists:buku,id_buku',
            'id_member' => 'required|exists:member,id_member',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_pinjam',
        ]);

        //menyimpan tanggal kembali lama untuk pengecekan
        $tglKembaliLama = $peminjaman->tgl_kembali;
        $bukuLama = $peminjaman->id_buku;
        
        //jika tgl_kembali kosong set default sebagai tanggal hari ini
        if (!$request->tgl_kembali) 
        {
            $request->merge(['tgl_kembali' => Carbon::now()->format('Y-m-d')]);
        }

        //update data peminjaman dari objek request
        $peminjaman->update($request->all());
        
        //cek apakah tanggal kembali baru diisi atau diubah
        $tglKembaliBaru = $peminjaman->tgl_kembali;
        $isTanggalKembaliDiubah = ($tglKembaliLama != $tglKembaliBaru);
        
        //menghitung keterlambatan pengembalian buku
        $tglPinjam = Carbon::parse($peminjaman->tgl_pinjam);
        $tglKembali = Carbon::parse($peminjaman->tgl_kembali);
        $tglKembaliSeharusnya = Carbon::parse($peminjaman->tgl_kembali_seharusnya);
        
        //default keterlambatan adalah 0
        $keterlambatan = 0;
        if ($tglKembali->gt($tglKembaliSeharusnya)) 
        {
            $keterlambatan = $tglKembali->diffInDays($tglKembaliSeharusnya); //diffInDays berarti perbedaan harinya berapa lama
        }
        
        //buat denda otomatis jika terlambat dan tanggal kembali baru saja diubah/diisi
        if ($keterlambatan > 0 && $isTanggalKembaliDiubah) {
            //cek apakah sudah ada denda untuk peminjaman ini
            $sudahDenda = Denda::where('id_pinjem', $peminjaman->id_pinjem)
                                ->where('jenis_denda', 'Keterlambatan')
                                ->first();
            
            $besarDenda = $keterlambatan * 1000; //besar denda diambil dari keterlambatan hari dikali seribu
            
            //jika sudah ada denda
            if ($sudahDenda) 
            {
                //update denda yang sudah ada
                $sudahDenda->update([
                    'besar_denda' => $besarDenda
                ]);
            } 
            //jika belum ada denda
            else 
            {
                //buat denda baru
                Denda::create([
                    'id_pinjem' => $peminjaman->id_pinjem,
                    'jenis_denda' => 'Keterlambatan',
                    'besar_denda' => $besarDenda,
                ]);
            }
        }

        $user = auth()->user(); //cek user yang sedang login
        $successMessage = 'Peminjaman berhasil diperbarui.'; //pesan apabila berhasil peminjaman berhasil diupdate
        
        //jika keterlambatann lebih dari 0 (ada keterlambatan)
        if ($keterlambatan > 0) 
        {
            $besarDenda = $keterlambatan * 1000; //besar denda adalah keterlambatan dikali 1000
            $successMessage .= ' Buku terlambat ' . $keterlambatan . ' hari. Denda: Rp ' . number_format($besarDenda, 0, ',', '.'); //pesan sukses dan keterangannya dengan formay angka
        }
        
        //jika user role yang sedang login adalah koordinator
        if ($user->role == 'koordinator') 
        {
            return redirect()->route('koordinator.peminjaman.view')->with('success', $successMessage);
        } 
        //jika user role yang sedang login adalah admin
        elseif ($user->role == 'admin') 
        {
            return redirect()->route('admin.peminjaman.view')->with('success', $successMessage);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peminjaman $peminjaman)
    {
        //menghapus data 
        //delete () adalah function
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
        //request adalah objek
        //validate untuk validasi data
        $request->validate([
            'periodeawal'=>'required|date',
            'periodeakhir'=>'required|date',
        ]);
        
        //mengambil data dari objek request (input) 
        //whereBetween berarti dari rentang (diantara)
        $data = Peminjaman::whereBetween('tgl_pinjam', [$request->periodeawal, $request->periodeakhir])->get(); 
        $pdf = Pdf::loadView('koordinator.pdf.template', compact('data')); //hasil dari cetak pdf diarahkan koordinator.pdf.template dengan mengambil objek data
        return $pdf->download('peminjaman.pdf'); //download pdf dengan nama peminjaman
        
    }
}
