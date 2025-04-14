@extends('layouts.app')

@section('content')
<div class="container">
    <a href="/admin/dashboard" class="btn btn-primary">Dashboard</a>
    <a href="/admin/buku" class="btn btn-primary">Lihat Buku</a>
    <a href="/admin/member" class="btn btn-primary">Lihat Member</a>
    <a href="/admin/kategori" class="btn btn-primary">Lihat Kategori</a>
    <a href="/admin/peminjaman" class="btn btn-primary">Lihat Peminjaman</a>
    <a href="/admin/denda" class="btn btn-primary">Lihat Denda</a>
    <h1>Daftar Peminjaman</h1>

    <a href="{{ route('peminjaman.create') }}" class="btn btn-primary mb-3">Tambah Peminjaman</a>
        
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID Peminjaman</th>
                <th>ID Buku</th>
                <th>ID Member</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjaman as $p)
                <tr>
                    <td>{{ $p->id_pinjem }}</td>
                    <td>{{ $p->buku->judul}}</td>
                    <td>{{ $p->member->nama}}</td>
                    <td>{{ $p->tgl_pinjam}}</td>
                    <td>{{ $p->tgl_kembali}}</td>
                    <td>
                        <a href="{{ route('peminjaman.edit', $p->id_pinjem) }}" class="btn btn-warning btn-sm">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
