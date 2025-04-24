@extends('layouts.app')
@extends('layouts.navbar')
@section('content')
            
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Daftar Buku</h2>
        <a href="{{ route('buku.create') }}" class="btn btn-primary">Tambah Buku</a>
    </div>


    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="text-align: center">ID Buku</th>
                <th style="text-align: center">Kategori</th>
                <th style="text-align: center">Cover</th>
                <th style="text-align: center">Judul</th>
                <th style="text-align: center">Penulis</th>
                <th style="text-align: center">Penerbit</th>
                <th style="text-align: center">Stok</th>
                <th style="text-align: center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            {{-- looping untuk menampilkan data buku --}}
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
