@extends('layouts.app')

@section('content')
<h1>Dashboard Admin</h1>
<a href="{{ route('buku.index') }}" class="btn btn-primary">Lihat Buku</a>
<a href="{{ route('member.index') }}" class="btn btn-primary">Lihat Member</a>
<a href="{{ route('kategori.index') }}" class="btn btn-primary">Lihat Kategori</a>
<a href="{{ route('peminjaman.index') }}" class="btn btn-primary">Lihat Peminjaman</a>
<a href="{{ route('denda.index') }}" class="btn btn-primary">Lihat Denda</a>
<form action="{{ route('logout') }}" method="POST">
    <a href="{{ route('logout') }}" class="btn btn-primary">Logout</a>
</form>
@endsection

