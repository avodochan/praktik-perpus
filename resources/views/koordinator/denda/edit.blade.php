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

    <form action="{{ route('denda.update', $denda->id_denda) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="id_pinjem" class="form-label">Nama Member</label>
            <select id="id_pinjem" name="id_pinjem" class="form-control" required>
                <option value="">Nama Member</option>
                @foreach ($peminjaman as $p)
                {{-- get peminjaman lalu menggunakan relasi ke tabel member dan get nama --}}
                <option value="{{ $p->id_pinjem}}" {{ old('id_pinjem') ?? $p->id_pinjem == $p->id_pinjem ? 'selected' : '' }}>
                    {{ $p->member->nama }}
                </option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-3">
            <label for="id_denda" class="form-label">Jenis Denda</label>
            <select id="jenis_denda" name="jenis_denda" class="form-control" required>
                    <option value="Terlambat">Terlambat</option>
            </select>
        </div>
        
        <div class="mb-3">
            <label for="besar_denda" class="form-label">Besar Denda</label>
            <input type="integer" id="besar_denda" name="besar_denda" class="form-control" value="{{ old('besar_denda') ?? $denda->besar_denda}}" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan Buku</button>
    </form>
</div>
@endsection
