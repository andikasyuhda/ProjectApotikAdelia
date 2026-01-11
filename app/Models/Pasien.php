<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pasien extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get all of the comments for the pasien
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function daftar(): HasMany
    {
        return $this->hasMany(daftar::class);
    }
}
