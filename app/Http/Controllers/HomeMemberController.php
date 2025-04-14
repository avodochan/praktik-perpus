<?php

namespace App\Http\Controllers;
use App\Models\Buku;
use App\Models\Denda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeMemberController extends Controller
{
    public function showbuku()
    {
        $buku = Buku::all();
        return view('user.buku.index', compact('buku'));    
    }

    public function showdenda()
    {
        $denda = Denda::all();
        return view('user.denda.index', compact('denda'));
    }
    public function showprofile()
    {        
        $user = auth()->user();
        return view('user.profile.index', compact('user'));
    }
}
