@extends('layouts.app')

@section('content')
    <h1>Daftar Denda</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Jenis Denda</th>
                <th>Besar Denda</th>
            </tr>
        </thead>
        <tbody>
            @foreach($denda as $d)
                <tr>
                    <td>{{ $d->jenis_denda }}</td>
                    <td>{{ $d->besar_denda }}</td>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
