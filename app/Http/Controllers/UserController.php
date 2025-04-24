<?php

namespace App\Http\Controllers;
use App\Models\Peminjaman;
use App\Models\Kategori;
use App\Models\Buku;
use App\Models\Member;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()//index adalah method
    {
        $user = auth()->user(); //cek user yang login
        //jika role user yang login adalah koordinator
        if($user->role =='koordinator')
        {
            $hitungPeminjaman = Peminjaman::count();
            $hitungBuku = Buku::count();
            $hitungKategori = Kategori::count();
            $hitungMember = Member::count();
            return view('koordinator.dashboard', compact('hitungPeminjaman', 'hitungBuku', 'hitungKategori', 'hitungMember'));
        }
        //jika role user yang login adalah admin
        elseif($user->role =='admin')
        {
            $hitungPeminjaman = Peminjaman::count();
            $hitungBuku = Buku::count();
            $hitungKategori = Kategori::count();
            $hitungMember = Member::count();
            return view('admin.dashboard', compact('hitungPeminjaman', 'hitungBuku', 'hitungKategori', 'hitungMember'));
        }
        //jika bukan keduanya
        else
        {
            $buku = Buku::orderBy('judul', 'asc')->get();
            $hitungBuku = Buku::count();
            return view('user.dashboard', compact ('buku','hitungBuku'));
        }
    }
    
}
