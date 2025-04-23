<?php

namespace App\Http\Controllers;
use App\Models\Buku;
use App\Models\Denda;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeMemberController extends Controller
{
    public function showbuku()
    {
        $buku = Buku::orderBy('judul', 'asc')->get();
        return view('user.buku.index', compact('buku'));    
    }

    public function showdenda()
    {
        $user = auth()->user()->member->id_member;
    
        // Ambil hanya denda yang terkait dengan peminjaman milik user yang login
        $denda = Denda::whereHas('peminjaman', function($query) use ($user) {
            $query->where('id_member', $user);
        })
        ->with(['peminjaman.buku']) // eager load relasi tambahan
        ->get()
        ->sortBy(function ($item) {
            return $item->peminjaman->tgl_pinjam;
        });
    
        // Tidak perlu ambil semua peminjaman, hanya yang dibutuhkan di view
        $totalNominal = $denda->sum('besar_denda');
    
        return view('user.denda.index', compact('denda', 'totalNominal'));
    }
    
    public function showprofile()
    {        
        $user = auth()->user();
        return view('user.profile.index', compact('user'));
    }
}
