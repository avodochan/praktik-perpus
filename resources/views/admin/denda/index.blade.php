@extends('layouts.app')
@extends('layouts.adminnavbar')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Daftar Denda</h2>
        <a href="{{ route('denda.create') }}" class="btn btn-primary">Tambah Denda</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Denda</th>
                <th>Nama Member</th>
                <th>Jenis Denda</th>
                <th>Besar Denda</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($denda as $d)
                <tr>
                    <td>{{ $d->id_denda}}</td>
                    <td>{{ $d->peminjaman->member->nama}}</td>
                    <td>{{ $d->jenis_denda}}</td>
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