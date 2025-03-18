@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Kategori</h1>

    <a href="{{ route('kategori.create') }}" class="btn btn-primary mb-3">Tambah Kategori</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID Kategori</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kategori as $k)
                <tr>
                    <td>{{ $k->id_kategori }}</td>
                    <td>{{ $k->nama_kategori }}</td>
                    <td>
                        <a href="{{ route('kategori.edit', $k->id_kategori) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('kategori.destroy', $k->id_kategori) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus kategori ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
