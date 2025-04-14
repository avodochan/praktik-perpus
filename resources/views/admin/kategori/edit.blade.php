@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Kategori</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <input type="text" id="id_kategori" name="id_kategori" class="form-control" value="{{ $kategori->id_kategori }}" disabled hidden>
        </div>

        <div class="mb-3">
            <label for="nama_kategori" class="form-label">Nama Kategori</label>
            <input type="text" id="nama_kategori" name="nama_kategori" class="form-control" value="{{ $kategori->nama_kategori }}" required>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
