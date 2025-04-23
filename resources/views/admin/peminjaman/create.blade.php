@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Peminjaman</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('peminjaman.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="id_buku" class="form-label">Judul Buku</label>
            <select class="form-select" id="id_buku" name="id_buku" required>
                <option value="">-- Pilih Buku --</option>
                @foreach($buku as $b)
                <option value="{{ $b->id_buku }}" {{ old('id_buku') == $b->id_buku ? 'selected' : '' }}>
                    {{ $b->judul }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="id_member" class="form-label">Member</label>
            <select class="form-select" id="id_member" name="id_member" required>
                <option value="">-- Pilih Member --</option>
                @foreach($members as $m)
                <option value="{{ $m->id_member }}" {{ old('id_member') == $m->id_member ? 'selected' : '' }}>
                    {{ $m->nama }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="tgl_pinjam" class="form-label">Tanggal Pinjam</label>
            <input type="date" id="tgl_pinjam" name="tgl_pinjam" class="form-control" value="{{ old('tgl_pinjam') }}" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan Peminjaman</button>
    </form>
</div>
@endsection
