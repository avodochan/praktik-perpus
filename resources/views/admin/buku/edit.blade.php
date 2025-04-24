@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('buku.update', $buku->id_buku) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="id_kategori" class="form-label">Kategori</label>
            <select id="id_kategori" name="id_kategori" class="form-control" required>
                <option value="">Pilih Kategori</option>
                @foreach ($kategori as $k)
                    <option value="{{ $k->id }}" {{ old('id') ?? $k->id == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="judul" class="form-label">Judul Buku</label>
            <input type="text" id="judul" name="judul" class="form-control" value="{{ old('judul') ?? $buku->judul }}" required>
        </div>

        <div class="mb-3">
            <label for="penulis" class="form-label">Penulis</label>
            <input type="text" id="penulis" name="penulis" class="form-control" value="{{ old('penulis') ?? $buku->penulis }}" required>
        </div>

        <div class="mb-3">
            <label for="penerbit" class="form-label">Penerbit</label>
            <input type="text" id="penerbit" name="penerbit" class="form-control" value="{{ old('penerbit') ?? $buku->penerbit}}" required>
        </div>

        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" id="stok" name="stok" class="form-control" value="{{ old('stok') ?? $buku->stok }}" required>
        </div>

        <div class="mb-3">
            <label for="cover" class="form-label">Cover Buku</label>
            <input type="file" id="cover" name="cover" class="form-control" accept="jpg">
            <p>preview cover sebelumnya:</p>
            {{-- get data foto dari storage untuk ditampilkan (preview) --}}
            <img src="{{ asset('storage/' . $buku->cover) }}" alt="Cover Buku" width="80"> 
        </div>

        <div class="mb-3">
            <label for="sinopsis" class="form-label">Sinopsis</label>
            <textarea id="sinopsis" name="sinopsis" class="form-control" rows="4" required>{{ old('sinopsis') ?? $buku->sinopsis }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Simpan Buku</button>
    </form>
</div>
@endsection
