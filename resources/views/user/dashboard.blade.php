@extends('layouts.app')
@extends('layouts.usernavbar')
@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
@endsection

