@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit</h1>

    {{-- get error apapun --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    {{-- edit adta denda sesuai dengan id yang dipilih --}}
    <form action="{{ route('denda.update', $denda->id_denda) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="id_pinjem" class="form-label">Nama Member</label>
            <select id="id_pinjem" name="id_pinjem" class="form-control" required>
                <option value="">Nama Member</option>
                @foreach ($peminjaman as $p)
                <option value="{{ $p->id_pinjem}}" {{ old('id_pinjem') ?? $p->id_pinjem == $p->id_pinjem ? 'selected' : '' }}>
                    {{ $p->member->nama }}
                </option>
                @endforeach
            </select>
        </div>
        
        {{-- jenis denda default adalah terlambat --}}
        <div class="mb-3">
            <select id="jenis_denda" name="jenis_denda" class="form-control" hidden>
                    <option value="Terlambat">Terlambat</option>
            </select>
        </div>
        
        {{-- edit besar denda --}}
        {{-- default besar denda diambil dari method update peminjaman --}}
        <div class="mb-3">
            <label for="besar_denda" class="form-label">Besar Denda</label>
            <input type="integer" id="besar_denda" name="besar_denda" class="form-control" value="{{ old('besar_denda') ?? $denda->besar_denda}}" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan Buku</button>
    </form>
</div>
@endsection
