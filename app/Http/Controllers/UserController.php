<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if($user->role =='koordinator')
        {
            return view('koordinator.dashboard');
        }
        elseif($user->role =='admin')
        {
            return view('admin.dashboard');
        }
        else{
            return view('user.dashboard');
        }
    }
    
}
