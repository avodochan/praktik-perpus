@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Member</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- get id member yang akan diedit --}}
    <form action="{{ route('member.update', $member->id_member)}}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" id="nama" name="nama" class="form-control" value="{{ old('nama') ?? $member->nama}}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" id="email" name="email" class="form-control" value="{{ old('email') ?? $member->email}}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Alamat</label>
            <input type="text" id="alamat" name="alamat" class="form-control" value="{{ old('alamat') ?? $member->alamat}}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">No Telp</label>
            <input type="number" id="no_tlp" name="no_tlp" class="form-control" value="{{ old('no_tlp') ?? $member->no_tlp}}" required>
        </div>

        <button type="submit" class="btn btn-success">Submit</button>
    </form>
</div>
@endsection
