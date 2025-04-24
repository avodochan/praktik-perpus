@extends('layouts.app')
@extends('layouts.adminnavbar')
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
            {{-- looping data buku --}}
            @foreach($buku as $b)
                <tr>
                    <td>{{ $b->id_buku }}</td>
                    <td>{{ $b->kategori->nama_kategori }}</td>
                    <td>
                        {{-- jika ada cover maka akan menampilkan--}}
                        @if($b->cover)
                            <img src="{{ asset('storage/' . $b->cover) }}" alt="Cover Buku" width="80">
                        {{-- jika tidak ada cover maka akan mereturn (tidak ada cover) --}}
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
                            {{-- konfirmasi apakah benar data akan dihapus --}}
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
