@extends('layouts.app')

@section('content')
<div class="container">
    <a href="/" class="btn btn-primary">Dashboard</a>
            <a href="/koordinator/kategori" class="btn btn-primary">Lihat Kategori</a>
            <a href="/koordinator/buku" class="btn btn-primary">Lihat Buku</a>
            <a href="/koordinator/peminjaman" class="btn btn-primary">Lihat Peminjaman</a>
            <a href="/koordinator/denda" class="btn btn-primary">Lihat Denda</a>
            <a href="/koordinator/member" class="btn btn-primary">Lihat Member</a>
    <h1>Daftar Peminjaman</h1>

    <a href="{{ route('peminjaman.create') }}" class="btn btn-primary mb-3">Tambah Peminjaman</a>
    
    <form action="{{ route('peminjaman.export') }}" method="GET" target="_blank">
        <label>Periode Awal :</label>
        <input type="date" name="periodeawal" required>
        <label>Periode Akhir :</label>
        <input type="date" name="periodeakhir" required>
        
        <button type="submit" class="btn btn-primary mb-3">Export Peminjaman</button>
    </form>
        
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

                        <form action="{{ route('peminjaman.destroy', $p->id_pinjem) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus peminjaman ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
