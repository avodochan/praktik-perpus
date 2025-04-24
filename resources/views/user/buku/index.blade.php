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
                <th>Detail</th>
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
                    <td>{{ $b->stok }}</td>
                    <td>
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#detailModal{{ $b->id_buku }}">
                            Detail
                        </button>
                    </td>
                    {{-- detail modal --}}
                    <div class="modal fade" id="detailModal{{ $b->id_buku }}" tabindex="-1" role="dialog" aria-labelledby="detailModalTitle{{ $b->id_buku }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h5 class="modal-title white" id="detailModalTitle{{ $b->id_buku }}" style="color: white">Detail Buku</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h6>Judul Buku : {{ $b->judul }}</h6>
                                            <h6>Penulis : {{ $b->penulis }}</h6>
                                            <h6>Penerbit : {{ $b->penerbit }}</h6>
                                            <h6>Sinopsis :</h6>
                                            <p>{{ $b->sinopsis }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
