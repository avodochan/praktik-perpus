@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Peminjaman</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('peminjaman.update', $peminjaman->id_pinjem) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="id_buku" class="form-label">Judul Buku</label>
            <select class="form-select" id="id_buku" name="id_buku" required>
                <option value="">-- Pilih Buku --</option>
                @foreach($buku as $b)
                <option value="{{ $b->id_buku }}" {{ old('id_buku') ?? $peminjaman->id_buku == $b->id_buku ? 'selected' : '' }}>
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
                <option value="{{ $m->id_member }}" {{ old('id_member') ?? $peminjaman->id_member == $m->id_member ? 'selected' : '' }}>
                    {{ $m->nama }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="tgl_pinjam_display" class="form-label">Tanggal Pinjam</label>
            <input type="text" id="tgl_pinjam_display" class="form-control" value="{{ Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d-m-Y') }}" readonly>
            <!--hidden input untuk menyimpan nilai asli ke database dengan format Y-m-d -->
            <input type="hidden" name="tgl_pinjam" value="{{ $peminjaman->tgl_pinjam }}">
        </div>

        <div class="mb-3">
            <label for="tgl_kembali_seharusnya" class="form-label">Tanggal Kembali Seharusnya</label>
            <input type="text" id="tgl_kembali_seharusnya" class="form-control" value="{{ Carbon\Carbon::parse($peminjaman->tgl_kembali_seharusnya)->format('d-m-Y') }}" readonly>
        </div>
        
        <div class="mb-3">
            <label for="tgl_kembali" class="form-label">Tanggal Kembali Sebenarnya</label>
            <input type="date" id="tgl_kembali" name="tgl_kembali" class="form-control" value="{{ old('tgl_kembali') ?? date('Y-m-d') }}">
        </div>
        
        <div class="mb-3">
            <select name="kondisi_buku" id="kondisi_buku" class="form-control @error('kondisi_buku') is-invalid @enderror" hidden>
                <option value="baik">Baik</option>
                <option value="rusak">Rusak</option>
                <option value="hilang">Hilang</option>
            </select>
            @error('kondisi_buku')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <button type="submit" class="btn btn-success">Simpan Peminjaman</button>
    </form>
</div>
@endsection