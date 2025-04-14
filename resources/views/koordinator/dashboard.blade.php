@extends('layouts.app')

@section('content')
<a href="/" class="btn btn-primary">Dashboard</a>
            <a href="/koordinator/kategori" class="btn btn-primary">Lihat Kategori</a>
            <a href="/koordinator/buku" class="btn btn-primary">Lihat Buku</a>
            <a href="/koordinator/peminjaman" class="btn btn-primary">Lihat Peminjaman</a>
            <a href="/koordinator/denda" class="btn btn-primary">Lihat Denda</a>
            <a href="/koordinator/member" class="btn btn-primary">Lihat Member</a>
<h1>Dashboard Koordinator</h1>
<form action="{{ route('logout') }}" method="POST">
    <a href="{{ route('logout') }}" class="btn btn-primary">Logout</a>
</form>
@endsection