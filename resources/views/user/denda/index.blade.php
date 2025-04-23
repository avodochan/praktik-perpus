@extends('layouts.app')
@extends('layouts.usernavbar')
@section('content')
    <h1>Daftar Denda</h1>
    
    <div class="alert alert-info" role="alert">
        Jumlah denda yang harus dibayarkan Rp {{ number_format($totalNominal, 0, ',', '.') }}
    </div>
      
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Tanggal Peminjaman</th>
                <th>Buku yang Dipinjam</th>
                <th>Jenis Denda</th>
                <th>Besar Denda</th>
            </tr>
        </thead>
        <tbody>
            @foreach($denda as $d)
                <tr>
                    <td>{{ $d->peminjaman->tgl_pinjam }}</td>
                    <td>{{ $d->peminjaman->buku->judul }}</td>
                    <td>{{ $d->jenis_denda }}</td>
                    <td>Rp {{ number_format($d->besar_denda, 0, ',', '.') }}</td>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
