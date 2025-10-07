@extends('layouts.app')
@section('title', 'Edit License')

@section('content')
    <h1>Edit License #{{ $license->id }}</h1>

    @if (session('success'))
        <div style="background:#e6ffed;border:1px solid #b7f5c8;padding:8px;margin:10px 0">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('licenses.update', $license) }}">
        @csrf @method('PUT')

        <p>
            <label>Email<br>
                <input type="email" name="email" value="{{ old('email', $license->email) }}" required>
            </label>
            @error('email')
                <br><small style="color:red">{{ $message }}</small>
            @enderror
        </p>

        <p>
            <label>Paket<br>
                <select name="package_id" required>
                    @foreach ($packages as $pkg)
                        <option value="{{ $pkg->id }}" @selected(old('package_id', $license->package_id) == $pkg->id)>
                            {{ $pkg->name }} {{ $pkg->duration_days ? "({$pkg->duration_days} hari)" : '' }}
                        </option>
                    @endforeach
                </select>
            </label>
            @error('package_id')
                <br><small style="color:red">{{ $message }}</small>
            @enderror
        </p>

        <p>
            <label>Aktif Mulai<br>
                <input type="date" name="active_from" value="{{ old('active_from', $license->active_from) }}" required>
            </label>
            @error('active_from')
                <br><small style="color:red">{{ $message }}</small>
            @enderror
        </p>

        <p>
            <label>Berlaku Sampai — kosongkan untuk auto dari paket<br>
                <input type="date" name="active_until" value="{{ old('active_until', $license->active_until) }}">
            </label>
            @error('active_until')
                <br><small style="color:red">{{ $message }}</small>
            @enderror
        </p>

        <p>
            <label>Serial (read-only)<br>
                <input type="text" value="{{ $license->serial }}" readonly>
            </label>
        </p>

        <p>
            <label>
                <input type="checkbox" name="is_used" value="1" @checked(old('is_used', $license->is_used))>
                Tandai sebagai digunakan
            </label>
        </p>

        <button type="submit">Update</button>
        <a href="{{ route('licenses.show', $license) }}">Kembali</a>
    </form>
@endsection
