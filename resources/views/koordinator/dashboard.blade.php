@extends('layouts.app')
@extends('layouts.navbar')
@section('content')
<div class="h1">
    Selamat Datang, Koordinator
</div>

<div class="col-12">
    <br>
    <div class="row">
        {{-- statistik banyak member --}}
        <div class="col-md-3">
            <div class="card shadow-sm text-center mb-4">
                <div class="card-body py-4">
                    <h2 class="text-primary fw-bold"> {{ $hitungMember}}</h2>
                    <p class="text-muted mb-0">Banyak Member</p>
                </div>
            </div>
        </div>
        {{-- statistik banyak kategori buku --}}
        <div class="col-md-3">
            <div class="card shadow-sm text-center mb-4">
                <div class="card-body py-4">
                    <h2 class="text-primary fw-bold"> {{ $hitungKategori}}</h2>
                    <p class="text-muted mb-0">Banyak Kategori</p>
                </div>
            </div>
        </div>
        {{-- statistik banyak buku --}}
        <div class="col-md-3">
            <div class="card shadow-sm text-center mb-4">
                <div class="card-body py-4">
                    <h2 class="text-primary fw-bold"> {{ $hitungBuku}}</h2>
                    <p class="text-muted mb-0">Banyak Buku</p>
                </div>
            </div>
        </div>
        {{-- statistik banyak peminjaman --}}
        <div class="col-md-3">
            <div class="card shadow-sm text-center mb-4">
                <div class="card-body py-4">
                    <h2 class="text-primary fw-bold"> {{ $hitungPeminjaman}}</h2>
                    <p class="text-muted mb-0">Banyak Peminjaman</p>
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection