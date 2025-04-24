@extends('layouts.app')
@extends('layouts.navbar')
@section('content')
<div class="container">
    <h1>Daftar Member</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
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
            {{-- looping untuk menampilkan data --}}
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
