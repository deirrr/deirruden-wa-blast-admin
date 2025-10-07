@extends('layouts.app')
@section('title', 'Tambah License')

@section('content')
    <h1>Tambah License</h1>

    <form method="POST" action="{{ route('licenses.store') }}">
        @csrf

        <p>
            <label>Email<br>
                <input type="email" name="email" value="{{ old('email') }}" required>
            </label>
            @error('email')
                <br><small style="color:red">{{ $message }}</small>
            @enderror
        </p>

        <p>
            <label>Paket<br>
                <select name="package_id" required>
                    <option value="">-- Pilih paket --</option>
                    @foreach ($packages as $pkg)
                        <option value="{{ $pkg->id }}" @selected(old('package_id') == $pkg->id)>
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
            <label>Aktif Mulai (active_from)<br>
                <input type="date" name="active_from" value="{{ old('active_from', now()->toDateString()) }}" required>
            </label>
            @error('active_from')
                <br><small style="color:red">{{ $message }}</small>
            @enderror
        </p>

        <p>
            <label>Berlaku Sampai (active_until) — opsional, kosongkan untuk auto dari paket<br>
                <input type="date" name="active_until" value="{{ old('active_until') }}">
            </label>
            @error('active_until')
                <br><small style="color:red">{{ $message }}</small>
            @enderror
        </p>

        {{-- serial tidak ditampilkan; otomatis dibuat saat simpan --}}

        <button type="submit">Simpan</button>
        <a href="{{ route('licenses.index') }}">Batal</a>
    </form>
@endsection
