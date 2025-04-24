<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Member;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
   public function showregister()
   {
     return view('auth.register');
   } 
   
   public function register(Request $request)
   {
      //input data ke tabel user
      $user = User::create([
        'name' => $request->nama,
        'email' => $request->email,
        'password' => bcrypt($request->password),
      ]);
      
      //input data ke tabel member
      //jadi saat user melakukan register, kata data dari objek user otomatis masuk ke dalam tabel user dan tabel member
      Member::create([
        'id_user' => $user->id,
        'nama' => $request->nama,
        'email' => $request->email,
        'alamat' => $request->alamat,
        'no_tlp' => $request->no_tlp,           
      ]);
          
      Auth::login($user); // login berdasarkan user yang ditemukan
      return redirect()->route('user.index'); //redirect ke halaman dashboard user   
   }
   
   public function showlogin()
   {
    //mengarahkan ke halaman login
     return view('auth.login');
   }
   
   public function login(Request $request)
  {
      //validasi input
      $request->validate([ //request adalah objek
          'email' => 'required|email',
          'password' => 'required',
      ]);

      $user = User::where('email', $request->email)->first(); //mencari data yang ada berdasarkan inputan
      
      if ($user && Hash::check($request->password, $user->password)) 
      { //kondisi jika data user ada dan password yang ada pada database sama dengan inputan
          Auth::login($user, $request->has('remember')); //login berdasarkan user yang ditemukan dan remember jika dicentang
          return redirect()->route('user.index'); //jika benar maka akan meredirect ke halaman dashboard user
      }
      else 
      {
          return redirect()->back()->withInput($request->only('email'))->with('error', 'Email atau Password salah'); //jika salah maka akan kembali ke halaman login dengan validasi error
      }
  }
   
   public function logout()//logout adalah method
   {
      Auth::logout(); //logout user
      return redirect()->route('login'); //redirect ke halaman login
   }
}
