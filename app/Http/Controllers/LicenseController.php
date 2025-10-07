<?php

namespace App\Http\Controllers;

use App\Models\License;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LicenseController extends Controller
{
    public function index(Request $request)
    {
        $q = License::with('package')->latest();

        // filter sederhana
        if ($s = $request->get('s')) {
            $q->where(function ($w) use ($s) {
                $w->where('email', 'like', "%$s%")
                    ->orWhere('serial', 'like', "%$s%");
            });
        }

        $licenses = $q->paginate(15)->withQueryString();
        return view('licenses.index', compact('licenses'));
    }

    public function create()
    {
        $packages = Package::orderBy('name')->get();
        return view('licenses.create', compact('packages'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'email'        => ['required', 'email'],
            'package_id'   => ['required', 'exists:packages,id'],
            'active_from'  => ['required', 'date'],
            'active_until' => ['nullable', 'date', 'after_or_equal:active_from'],
        ]);

        // auto isi active_until dari duration paket kalau kosong
        if (empty($data['active_until'])) {
            $pkg = Package::find($data['package_id']);
            if ($pkg && $pkg->duration_days) {
                $data['active_until'] = now()->parse($data['active_from'])
                    ->addDays($pkg->duration_days)->toDateString();
            }
        }

        $license = License::create($data); // serial auto di model

        return redirect()
            ->route('licenses.show', $license)
            ->with('success', "License dibuat dengan serial: {$license->serial}");
    }

    public function show(License $license)
    {
        $license->load('package');
        return view('licenses.show', compact('license'));
    }

    public function edit(License $license)
    {
        $packages = Package::orderBy('name')->get();
        return view('licenses.edit', compact('license', 'packages'));
    }

    public function update(Request $request, License $license)
    {
        $data = $request->validate([
            'email'        => ['required', 'email'],
            'package_id'   => ['required', 'exists:packages,id'],
            'active_from'  => ['required', 'date'],
            'active_until' => ['nullable', 'date', 'after_or_equal:active_from'],
            // serial tidak diubah dari form (auto), tapi tetap validasi kalau dikirim
            'serial'       => ['sometimes', 'string', 'max:64', Rule::unique('licenses', 'serial')->ignore($license->id)],
            'is_used'      => ['sometimes', 'boolean'],
        ]);

        if (empty($data['active_until'])) {
            $pkg = Package::find($data['package_id']);
            if ($pkg && $pkg->duration_days) {
                $data['active_until'] = now()->parse($data['active_from'])
                    ->addDays($pkg->duration_days)->toDateString();
            }
        }

        $license->update($data);

        return redirect()->route('licenses.show', $license)->with('success', 'License diupdate.');
    }

    public function destroy(License $license)
    {
        $license->delete();
        return redirect()->route('licenses.index')->with('success', 'License dihapus.');
    }
}
