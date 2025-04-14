@extends('layouts.app')

@section('content')
            <a href="/" class="btn btn-primary">Dashboard</a>
            <a href="/koordinator/kategori" class="btn btn-primary">Lihat Kategori</a>
            <a href="/koordinator/buku" class="btn btn-primary">Lihat Buku</a>
            <a href="/koordinator/peminjaman" class="btn btn-primary">Lihat Peminjaman</a>
            <a href="/koordinator/denda" class="btn btn-primary">Lihat Denda</a>
            <a href="/koordinator/member" class="btn btn-primary">Lihat Member</a>
    <h1>Daftar Buku</h1>
    <a href="{{ route('buku.create') }}" class="btn btn-primary">Tambah Buku</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID Buku</th>
                <th>Kategori</th>
                <th>Cover</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($buku as $b)
                <tr>
                    <td>{{ $b->id_buku }}</td>
                    <td>{{ $b->kategori->nama_kategori }}</td>
                    <td>
                        @if($b->cover)
                            <img src="{{ asset('storage/' . $b->cover) }}" alt="Cover Buku" width="80">
                        @else
                            <span>Tidak ada cover</span>
                        @endif
                    </td>
                    <td>{{ $b->judul }}</td>
                    <td>{{ $b->penulis }}</td>
                    <td>{{ $b->penerbit }}</td>
                    <td>{{ $b->stok }}</td>
                    <td>
                        <a href="{{ route('buku.edit', $b->id_buku) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('buku.destroy', $b->id_buku) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
