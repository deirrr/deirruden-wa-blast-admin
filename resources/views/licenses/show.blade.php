@extends('layouts.app')
@section('title', 'Detail License')

@section('content')
    <h1>Detail License #{{ $license->id }}</h1>

    @if (session('success'))
        <div style="background:#e6ffed;border:1px solid #b7f5c8;padding:8px;margin:10px 0">{{ session('success') }}</div>
    @endif

    <p><b>Email:</b> {{ $license->email }}</p>
    <p><b>Paket:</b> {{ $license->package->name ?? '-' }}</p>
    <p><b>Serial:</b> <code>{{ $license->serial }}</code></p>
    <p><b>Masa aktif:</b> {{ $license->active_from }} → {{ $license->active_until ?? '-' }}</p>
    <p><b>Status:</b> {{ $license->status }}</p>
    <p><b>Used at:</b> {{ $license->used_at ?? '-' }}</p>

    <p>
        <a href="{{ route('licenses.edit', $license) }}">Edit</a> |
        <a href="{{ route('licenses.index') }}">Kembali</a>
    </p>
@endsection
