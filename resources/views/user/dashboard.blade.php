@extends('layouts.app')
@extends('layouts.usernavbar')
@section('content')
    <div class="h1">
        Selamat Datang
    </div>
    <div class="col-12">
        <br>
        <div class="row">
            <br>
            <div class="col-md-12">
                <div class="card shadow-sm text-center mb-4">
                    <div class="card-body py-4">
                        <h2 class="text-primary fw-bold"> {{ $hitungBuku}}</h2>
                        <p class="text-muted mb-0">Banyak Buku</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <table class="table ">
                <thead>
                    <tr>
                        <th>Cover</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($buku as $b)
                    {{-- looping untuk menampilkan data --}}
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection