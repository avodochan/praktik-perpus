@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Profile</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" id="nama" name="nama" class="form-control" value="{{ old('nama', $user->name) }}" disabled>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" disabled>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-control" value="{{ old('password') }}" disabled>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Alamat</label>
            <input type="text" id="alamat" name="alamat" class="form-control" value="{{ old('alamat', $user->member->alamat) }}" disabled>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">No Telp</label>
            <input type="number" id="no_tlp" name="no_tlp" class="form-control" value="{{ old('no_tlp', $user->member->no_tlp) }}" disabled>
        </div>
    </form>
</div>
@endsection
