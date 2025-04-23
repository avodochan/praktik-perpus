<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DendaController;
use App\Http\Controllers\HomeMembeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\HomeMemberController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.index')->middleware(['auth', 'checkrole:admin']);

Route::get('/', [UserController::class, 'index'])->name('user.index');
Route::get('/register', [AuthController::class, 'showregister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'showlogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

//admin routes
Route::middleware(['auth', 'checkrole:admin'])->group(function() 
{
    Route::resource('kategori', KategoriController::class);
    Route::get('/admin/kategori', [KategoriController::class, 'index'])->name('admin.kategori.view');
    Route::resource('buku', BukuController::class);
    Route::get('/admin/buku', [BukuController::class, 'index'])->name('admin.buku.view');
    Route::resource('peminjaman', PeminjamanController::class);
    Route::get('/admin/peminjaman', [PeminjamanController::class, 'index'])->name('admin.peminjaman.view');
    Route::resource('member', MemberController::class);
    Route::get('/admin/member', [MemberController::class, 'index'])->name('admin.member.view');
    Route::resource('denda', DendaController::class);
    Route::get('/admin/denda', [DendaController::class, 'index'])->name('admin.denda.view');
});

//koordinator routes
Route::middleware(['auth', 'checkrole:koordinator'])->group(function() 
{
    Route::resource('kategori', KategoriController::class)->except('kategori.destroy');
    Route::get('/koordinator/kategori', [KategoriController::class, 'koordinatorview'])->name('koordinator.kategori.view');
    Route::resource('buku', BukuController::class);
    Route::get('/koordinator/buku', [BukuController::class, 'koordinatorview'])->name('koordinator.buku.view');
    Route::resource('peminjaman', PeminjamanController::class);
    Route::get('/koordinator/peminjaman', [PeminjamanController::class, 'koordinatorview'])->name('koordinator.peminjaman.view');
    Route::get('/export-pdf', [PeminjamanController::class, 'exportPDF'])->name('peminjaman.export');
    Route::resource('member', MemberController::class);
    Route::get('/koordinator/member', [MemberController::class, 'koordinatorview'])->name('koordinator.member.view');
    Route::resource('denda', DendaController::class);
    Route::get('/koordinator/denda', [DendaController::class, 'koordinatorview'])->name('koordinator.denda.view');

});

//user routes
Route::middleware(['auth', 'checkrole:user'])->group(function()
{
    Route::get('/user/showbuku', [HomeMemberController::class, 'showbuku'])->name('showbuku');
    Route::get('/user/showprofile', [HomeMemberController::class, 'showprofile'])->name('showprofile');
    Route::get('/user/showdenda', [HomeMemberController::class, 'showdenda'])->name('showdenda');
});
