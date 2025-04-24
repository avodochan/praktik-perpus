<?php

namespace App\Http\Controllers;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // menghitung total peminjaman
        $hitungPeminjaman = Peminjaman::count();
        return view ('koordinator.dashboard', compact ('hitungPeminjaman'));
    }
}
