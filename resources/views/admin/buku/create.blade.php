@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Buku Baru</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="id_buku" class="form-label">ID Buku</label>
            <input type="text" id="id_buku" name="id_buku" class="form-control" value="{{ old('id_buku') }}" required>
        </div>

        <div class="mb-3">
            <label for="id_kategori" class="form-label">Kategori</label>
            <select id="id_kategori" name="id_kategori" class="form-control" required>
                <option value="">Pilih Kategori</option>
                @foreach ($kategori as $k)
                    <option value="{{ $k->id_kategori }}" {{ old('id_kategori') == $k->id_kategori ? 'selected' : '' }}>
                        {{ $k->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="judul" class="form-label">Judul Buku</label>
            <input type="text" id="judul" name="judul" class="form-control" value="{{ old('judul') }}" required>
        </div>

        <div class="mb-3">
            <label for="penulis" class="form-label">Penulis</label>
            <input type="text" id="penulis" name="penulis" class="form-control" value="{{ old('penulis') }}" required>
        </div>

        <div class="mb-3">
            <label for="penerbit" class="form-label">Penerbit</label>
            <input type="text" id="penerbit" name="penerbit" class="form-control" value="{{ old('penerbit') }}" required>
        </div>

        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" id="stok" name="stok" class="form-control" value="{{ old('stok') }}" required>
        </div>

        <div class="mb-3">
            <label for="cover" class="form-label">Cover Buku</label>
            <input type="file" id="cover" name="cover" class="form-control">
        </div>

        <div class="mb-3">
            <label for="sinopsis" class="form-label">Sinopsis</label>
            <textarea id="sinopsis" name="sinopsis" class="form-control" rows="4" required>{{ old('sinopsis') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Simpan Buku</button>
        <a href="{{ route('buku.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
