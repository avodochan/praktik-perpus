@extends('layouts.app')

@section('content')
    <h1>Dashboard user</h1>
    <a href="{{ route('showbuku') }}" class="btn btn-primary">Show Buku</a>
    <a href="{{ route('showdenda') }}" class="btn btn-primary">Show Denda</a>
    <a href="{{ route('showprofile') }}" class="btn btn-primary">View Profile</a>
    <a href="{{ route('logout') }}" class="btn btn-primary">Logout</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
@endsection

