@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h1 class="h3 mb-0">Login</h1>
                </div>
                <div class="card-body">
                    {{-- get error apapun --}}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- form untuk melakukan login --}}
                    <form action="{{ route('login') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">Login</button>
                        </div>
                    </form>
                    
                    {{-- jika belum punya akun --}}
                    <div class="text-center mt-3">
                        <p>Belum punya akun?</p>
                        {{-- button mengarahkan ke halaman register --}}
                        <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection