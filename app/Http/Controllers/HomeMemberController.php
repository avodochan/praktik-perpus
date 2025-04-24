<?php

namespace App\Http\Controllers;
use App\Models\Buku;
use App\Models\Denda;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeMemberController extends Controller
{
    //method untuk menampilkan buku
    public function showbuku()
    {
        $buku = Buku::orderBy('judul', 'asc')->get(); //mengambil data buku dari tabel buku dengan format ascending (berurut a-z)
        return view('user.buku.index', compact('buku')); //compact adalah function
    }

    //method untuk menampilkan denda
    public function showdenda()
    {
        $user = auth()->user()->member->id_member; //cek user yang login 
    
        //ambil hanya denda milik user yang login
        $denda = Denda::whereHas('peminjaman', function($query) use ($user) {
            $query->where('id_member', $user);
        })
        ->with(['peminjaman.buku']) 
        ->get()
        ->sortBy(function ($item) { //urutkan berdasarkan peminjaman
            return $item->peminjaman->tgl_pinjam;
        });
    
        //menghitung besar denda menggunakan function sum()
        $totalNominal = $denda->sum('besar_denda');
    
        return view('user.denda.index', compact('denda', 'totalNominal')); //mengembalikan ke halaman user.denda.index 
    }
    
    //method untuk menampilkan profile user yang sedang login
    public function showprofile()
    {        
        $user = auth()->user(); //cek user yang sedang login
        return view('user.profile.index', compact('user')); //get dari objek user
    }
}
