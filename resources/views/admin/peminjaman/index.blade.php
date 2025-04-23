@extends('layouts.app')
@extends('layouts.adminnavbar')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Daftar Peminjaman</h2>
        <a href="{{ route('peminjaman.create') }}" class="btn btn-primary">Tambah Peminjaman</a>
    </div>
        
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Peminjaman</th>
                <th>Judul Buku</th>
                <th>Nama Member</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali Seharusnya</th>
                <th>Tanggal Kembali Sebenarnya</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjaman as $p)
                <tr>
                    <td>{{ $p->id_pinjem }}</td>
                    <td>{{ $p->buku->judul}}</td>
                    <td>{{ $p->member->nama}}</td>
                    <td>{{ $p->tgl_pinjam_formatted }}</td>
                    <td>{{ $p->tgl_kembali_seharusnya }}</td>
                    <td>{{ $p->tgl_kembali_sebenarnya }}</td>
                    <td>
                        <a href="{{ route('peminjaman.edit', $p->id_pinjem) }}" class="btn btn-warning btn-sm">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
