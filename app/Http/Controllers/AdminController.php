<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        //mengarahkan ke halaman dashboard admin
        return redirect('admin.dashboard');
    }
}
