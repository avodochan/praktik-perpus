@extends('layouts.app')

@section('content')
<div class="container">
    <a href="/" class="btn btn-primary">Dashboard</a>
            <a href="/koordinator/kategori" class="btn btn-primary">Lihat Kategori</a>
            <a href="/koordinator/buku" class="btn btn-primary">Lihat Buku</a>
            <a href="/koordinator/peminjaman" class="btn btn-primary">Lihat Peminjaman</a>
            <a href="/koordinator/denda" class="btn btn-primary">Lihat Denda</a>
            <a href="/koordinator/member" class="btn btn-primary">Lihat Member</a>
    <h1>Daftar Member</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID Member</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Alamat</th>
                <th>No Telepon</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($member as $m)
                <tr>
                    <td>{{ $m->id_member }}</td>
                    <td>{{ $m->nama}}</td>
                    <td>{{ $m->email}}</td>
                    <td>{{ $m->alamat}}</td>
                    <td>{{ $m->no_tlp}}</td>
                    <td>
                        <a href="{{ route('member.edit', $m->id_member) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('member.destroy', $m->id_member) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus member ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
