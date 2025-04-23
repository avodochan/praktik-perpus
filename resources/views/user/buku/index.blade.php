@extends('layouts.app')
@extends('layouts.usernavbar')
@section('content')
    <h1>Daftar Buku</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table ">
        <thead>
            <tr>
                <th>Cover</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach($buku as $b)
                <tr>
                    <td>
                        @if($b->cover)
                            <img src="{{ asset('storage/' . $b->cover) }}" alt="Cover Buku" width="80">
                        @else
                            <span>Tidak ada cover</span>
                        @endif
                    </td>
                    <td>{{ $b->judul }}</td>
                    <td>{{ $b->penulis }}</td>
                    <td>{{ $b->penerbit }}</td>
                    <td>{{ $b->stok }}</td>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
