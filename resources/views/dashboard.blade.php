@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <h1>Dashboard</h1>

    <div class="toolbar">
        <a class="btn" href="{{ route('licenses.index') }}">Kelola Licenses</a>
        <a class="btn" href="{{ route('licenses.create') }}">+ Tambah License</a>
    </div>

    <p>Selamat datang, <b>{{ Auth::user()->name }}</b>. Gunakan menu di atas untuk navigasi.</p>
@endsection
