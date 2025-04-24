@extends('layouts.app')
@extends('layouts.adminnavbar')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Daftar Denda</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            {{-- data apa saja yang akan ditampilkan --}}
            <tr>
                <th>ID Denda</th>
                <th>Nama Member</th>
                <th>Jenis Denda</th>
                <th>Besar Denda</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            {{-- looping untuk menampilkan data denda --}}
            @foreach($denda as $d)
                <tr>
                    <td>{{ $d->id_denda}}</td>
                    {{-- relasi dari tabel denda ke tabel peminjaman lalu ke tabel member dan get nama (relasi ini sudah didefinisikan di model) --}}
                    <td>{{ $d->peminjaman->member->nama}}</td>
                    <td>{{ $d->jenis_denda}}</td>
                    {{-- mengambil besar denda dan diformat --}}
                    <td>Rp {{ number_format($d->besar_denda, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('denda.edit', $d->id_denda) }}" class="btn btn-warning btn-sm">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection