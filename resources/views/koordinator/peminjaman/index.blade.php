@extends('layouts.app')
@extends('layouts.navbar')
@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Daftar Peminjaman</h2>
        <a href="{{ route('peminjaman.create') }}" class="btn btn-primary">Tambah Peminjaman</a>
    </div>
    
    <form action="{{ route('peminjaman.export') }}" method="GET" target="_blank">
        <div class="row">
            <div class="col-3">
                <label for="periodeawal" class="form-label">Periode Awal:</label>
                <input type="date" name="periodeawal" id="periodeawal" class="form-control" required>
            </div>
            <div class="col-3">
                <label for="periodeakhir" class="form-label">Periode Akhir:</label>
                <input type="date" name="periodeakhir" id="periodeakhir" class="form-control" required>                
            </div>
            <div class="col-3 d-flex align-items-end">
                <button type="submit" class="btn btn-outline-success w-100">Export Peminjaman</button>               
            </div>
        </div>
    </form>
 
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <br>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Peminjaman</th>
                <th>ID Buku</th>
                <th>ID Member</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali Seharusnya</th>
                <th>Tanggal Kembali Sebenarnya</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjaman as $p)
                <tr>
                    <td>{{ $p->id_pinjem }}</td>
                    <td>{{ $p->buku->judul}}</td>
                    <td>{{ $p->member->nama}}</td>
                    <td>{{ $p->tgl_pinjam_formatted }}</td>
                    <td>{{ $p->tgl_kembali_seharusnya }}</td>
                    <td>{{ $p->tgl_kembali_sebenarnya ?? '-'}}</td>
                    <td>
                        <span class="badge bg-{{ $p['status_class'] }}">{{ $p['status_text'] }}</span>
                    </td>
                    <td>
                        <a href="{{ route('peminjaman.edit', $p->id_pinjem) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('peminjaman.destroy', $p->id_pinjem) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus peminjaman ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
