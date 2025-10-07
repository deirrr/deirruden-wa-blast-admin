@extends('layouts.app')
@section('title', 'Licenses')

@section('content')
    <h1>Licenses</h1>

    @if (session('success'))
        <div style="background:#e6ffed;border:1px solid #b7f5c8;padding:8px;margin:10px 0">{{ session('success') }}</div>
    @endif

    <div style="display:flex;gap:8px;align-items:center;margin:10px 0">
        <a href="{{ route('licenses.create') }}">+ Tambah License</a>
        <form method="GET" action="{{ route('licenses.index') }}" style="margin-left:auto">
            <input type="text" name="s" placeholder="Cari email/serial" value="{{ request('s') }}">
            <button type="submit">Cari</button>
        </form>
    </div>

    <table border="1" cellpadding="6" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Paket</th>
                <th>Serial</th>
                <th>Masa Aktif</th>
                <th>Status</th>
                <th>Digunakan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($licenses as $lic)
                <tr>
                    <td>{{ $lic->id }}</td>
                    <td>{{ $lic->email }}</td>
                    <td>{{ $lic->package->name ?? '-' }}</td>
                    <td><code>{{ $lic->serial }}</code></td>
                    <td>{{ $lic->active_from }} → {{ $lic->active_until ?? '-' }}</td>
                    <td>{{ $lic->status }}</td>
                    <td>{{ $lic->used_at ? $lic->used_at : '-' }}</td>
                    <td>
                        <a href="{{ route('licenses.show', $lic) }}">Detail</a> |
                        <a href="{{ route('licenses.edit', $lic) }}">Edit</a> |
                        <form action="{{ route('licenses.destroy', $lic) }}" method="POST" style="display:inline"
                            onsubmit="return confirm('Hapus license ini?')">
                            @csrf @method('DELETE')
                            <button type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Belum ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:10px">
        {{ $licenses->links() }}
    </div>
@endsection
