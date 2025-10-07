<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\License;
use Illuminate\Http\Request;

class LicenseApiController extends Controller
{
    // GET /api/license/verify?email=...&serial=...
    public function verify(Request $request)
    {
        $data = $request->validate([
            'email'  => ['required', 'email'],
            'serial' => ['required', 'string'],
        ]);

        $license = License::with('package')
            ->where('email', $data['email'])
            ->where('serial', $data['serial'])
            ->first();

        if (!$license) {
            return response()->json(['valid' => false, 'reason' => 'not_found'], 404);
        }

        // cek expired
        $today = now()->toDateString();
        if ($license->active_until && $today > $license->active_until) {
            return response()->json([
                'valid' => false,
                'reason' => 'expired',
                'active_until' => $license->active_until,
            ], 200);
        }

        return response()->json([
            'valid' => true,
            'status' => $license->status, // 'unused' | 'used' | 'expired'
            'email' => $license->email,
            'package' => $license->package?->name,
            'active_from' => $license->active_from,
            'active_until' => $license->active_until,
            'used_at' => $license->used_at,
        ]);
    }

    // POST /api/license/activate  { email, serial }
    public function activate(Request $request)
    {
        $data = $request->validate([
            'email'  => ['required', 'email'],
            'serial' => ['required', 'string'],
        ]);

        $license = License::where('email', $data['email'])
            ->where('serial', $data['serial'])
            ->first();

        if (!$license) {
            return response()->json(['success' => false, 'reason' => 'not_found'], 404);
        }

        // cek expired
        $today = now()->toDateString();
        if ($license->active_until && $today > $license->active_until) {
            return response()->json(['success' => false, 'reason' => 'expired'], 200);
        }

        if ($license->is_used) {
            // Idempotent: sudah aktif → balikan sukses dengan info
            return response()->json([
                'success' => true,
                'message' => 'already_used',
                'used_at' => $license->used_at,
            ]);
        }

        $license->is_used = true;
        $license->used_at = now();
        $license->save();

        return response()->json([
            'success' => true,
            'message' => 'activated',
            'used_at' => $license->used_at,
        ]);
    }
}
