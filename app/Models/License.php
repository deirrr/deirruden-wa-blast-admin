<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class License extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'package_id',
        'serial',
        'active_from',
        'active_until',
        'is_used',
        'used_at'
    ];

    protected static function booted()
    {
        static::creating(function ($license) {
            if (empty($license->serial)) {
                // Format: XXXX-XXXX-XXXX-XXXX
                $license->serial = strtoupper(implode('-', [
                    Str::random(4),
                    Str::random(4),
                    Str::random(4),
                    Str::random(4)
                ]));
            }
        });
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function getStatusAttribute(): string
    {
        if ($this->is_used) return 'used';
        if ($this->active_until && now()->toDateString() > $this->active_until) return 'expired';
        return 'unused';
    }
}
