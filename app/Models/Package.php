<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'duration_days', 'price'];

    public function licenses()
    {
        return $this->hasMany(License::class);
    }
}
