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
    public function index()
    { 
        $peminjaman = Peminjaman::with(['buku', 'member'])->get();
        return view('admin.peminjaman.index', compact('peminjaman'));
    }
    
    public function koordinatorview()
    {
        $peminjaman = Peminjaman::with(['buku', 'member'])->get();
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
        //exists berarti ada di dalam tabel (nama tabel) dan di kolom (nama kolom)
        //after_or_equal sebagai validasi bahwa tgl_kembali harus setelah atau sama dengan tgl_pinjam
        $request->validate([
            'id_buku' => 'required|exists:buku,id_buku',
            'id_member' => 'required|exists:member,id_member',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_pinjam',
            'kondisi_buku' => 'required|in:baik,rusak,hilang', //validasi kondisi buku
        ]);

        //jika tgl_kembali kosong, set default dengan tanggal hari ini
        if (!$request->tgl_kembali) 
        {
            $request->merge(['tgl_kembali' => Carbon::now()->format('Y-m-d')]);
        }

        //menyimpan status lama untuk mengecek apakah tgl_kembali baru diisi
        $tglKembaliLama = $peminjaman->tgl_kembali;
        
        //update seluruh data peminjaman yang sudah ada di objek request
        $peminjaman->update($request->all());
        
        $pesanDenda = '';
        
        //cek apakah ini adalah proses pengembalian (tgl_kembali baru diisi atau diubah)
        if ((!$tglKembaliLama && $peminjaman->tgl_kembali) || ($tglKembaliLama != $peminjaman->tgl_kembali)) 
        {
            //menghitung tgl_kembali_seharusnya (H+7 dari tgl_pinjam)
            $tglKembaliSeharusnya = Carbon::parse($peminjaman->tgl_pinjam)->addDays(7);
            $tglKembaliSebenarnya = Carbon::parse($peminjaman->tgl_kembali);
            
            //array untuk menampung jenis denda yang perlu ditambahkan
            $dendaYangPerluDitambahkan = [];
            
            //semua jenis denda besarnya 50.000 (dibuat percabangan jika ada kasus besarnya berbeda)
            //jika kondisi buku rusak
            //maka jenis dendanya adalah rusak, dan besarnya 50.000
            if ($request->kondisi_buku == 'rusak') {
                $dendaYangPerluDitambahkan[] = [
                    'jenis_denda' => 'Rusak',
                    'besar_denda' => 50000,
                    'pesan' => 'denda kerusakan buku Rp 50.000' //pesan yang ditampilkan saat menambahkan denda
                ];
            } 
            //jika kondisi buku hilang
            else if ($request->kondisi_buku == 'hilang') {
                $dendaYangPerluDitambahkan[] = [
                    'jenis_denda' => 'Hilang',
                    'besar_denda' => 50000,
                    'pesan' => 'denda menghilangkan buku Rp 50.000'
                ];
            }
            
            //jika buku terlambat (melebihi tanggal kembali seharusnya)
            //gt adalah greater than (lebih dari)
            if ($tglKembaliSebenarnya->gt($tglKembaliSeharusnya)) {
                $dendaYangPerluDitambahkan[] = [
                    'jenis_denda' => 'Terlambat',
                    'besar_denda' => 50000,
                    'pesan' => 'denda keterlambatan Rp 50.000'
                ];
            }
            
            //mengambil semua data denda yang sudah ada untuk peminjaman ini dari database
            //menggunakan get() untuk data dari semua denda dengan id_peminjaman ini
            $sudahDenda = Denda::where('id_pinjem', $peminjaman->id_pinjem)->get();

            //pluck() mengambil nilai dari kolom tertentu dari setiap objek dalam koleksi
            //toArray() mengubah hasilnya menjadi array PHP biasa
            $jenisDendaYangSudahAda = $sudahDenda->pluck('jenis_denda')->toArray();

            //array untuk membuat pesan sukses 
            $pesanDendaArray = [];

            //cek apa ada denda yang perlu ditambahkan
            //jika array dendaYangPerluDitambahkan tidak kosong, lanjutkan proses
            if (count($dendaYangPerluDitambahkan) > 0) 
            {
                foreach ($dendaYangPerluDitambahkan as $denda) 
                {
                    //cek apakah jenis denda ini sudah ada dalam database
                    //in_array() memeriksa apakah nilai ada dalam array
                    //jika jenis denda belum ada dalam daftar jenisDendaYangSudahAda, maka tambahkan
                    if (!in_array($denda['jenis_denda'], $jenisDendaYangSudahAda)) {
                        //membuat record denda baru dalam database
                        Denda::create([
                            'id_pinjem' => $peminjaman->id_pinjem,
                            'jenis_denda' => $denda['jenis_denda'],
                            'besar_denda' => $denda['besar_denda'],
                        ]);
                        //menambahkan pesan denda ke array pesanDendaArray
                        $pesanDendaArray[] = $denda['pesan'];
                    }
                }
            }

            //pesan denda
            //jika ada denda yang berhasil ditambahkan (pesanDendaArray tidak kosong)
            if (count($pesanDendaArray) > 0) 
            {
                //menggabungkan semua pesan denda dengan 'dan'
                //implode() menggabungkan array menjadi string dengan separator tertentu
                $pesanDenda = ' dan ' . implode(' dan ', $pesanDendaArray) . ' telah ditambahkan';
            } 
            //jika tidak ada denda yang ditambahkan, tetapi sudah ada denda tercatat sebelumnya
            else if (count($sudahDenda) > 0) 
            {
                $pesanDenda = ' (sudah ada denda tercatat)';
            } 
            //jika tidak ada denda yang ditambahkan dan tidak ada denda yang tercatat sebelumnya
            else 
            {
                $pesanDenda = ' tanpa denda';
            }
        }

        //cek user yang login
        $user = auth()->user();
        //jika user yang login adalah koordinator
        if ($user->role == 'koordinator') 
        {
            return redirect()->route('koordinator.peminjaman.view') //setelah data berhasil dihapus maka akan mengarah ke route koordinator.peminjaman.view
                ->with('success', 'Peminjaman berhasil diperbarui' . $pesanDenda); //dengan validasi sukses dan keterangannya
        }
        //jika yang login adalah admin 
        elseif ($user->role == 'admin') 
        {
            return redirect()->route('admin.peminjaman.view') //setelah data berhasil dihapus maka akan mengarah ke route koordinator.peminjaman.view
                ->with('success', 'Peminjaman berhasil diperbarui' . $pesanDenda); //dengan validasi sukses dan keterangannya
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
