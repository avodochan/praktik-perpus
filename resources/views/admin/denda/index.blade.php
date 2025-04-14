@extends('layouts.app')

@section('content')
<div class="container">
    <a href="/admin/dashboard" class="btn btn-primary">Dashboard</a>
    <a href="/admin/buku" class="btn btn-primary">Lihat Buku</a>
    <a href="/admin/member" class="btn btn-primary">Lihat Member</a>
    <a href="/admin/kategori" class="btn btn-primary">Lihat Kategori</a>
    <a href="/admin/peminjaman" class="btn btn-primary">Lihat Peminjaman</a>
    <a href="/admin/denda" class="btn btn-primary">Lihat Denda</a>
    <h1>Daftar Denda</h1>

    <a href="{{ route('denda.create') }}" class="btn btn-primary mb-3">Tambah Denda</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID Denda</th>
                <th>Nama Member</th>
                <th>Jenis Denda</th>
                <th>Besar Denda</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($denda as $d)
                <tr>
                    <td>{{ $d->id_denda}}</td>
                    <td>{{ $d->id_pinjem}}</td>
                    <td>{{ $d->jenis_denda}}</td>
                    <td>{{ $d->besar_denda}}</td>
                    <td>
                        <a href="{{ route('denda.edit', $d->id_denda) }}" class="btn btn-warning btn-sm">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
