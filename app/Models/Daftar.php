<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Daftar extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the user that owns the daftar
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pasien(): BelongsTo
    {
        return $this->belongsTo(pasien::class)->withDefault();
    }

    public function poli(): BelongsTo
    {
        return $this->belongsTo(poli::class)->withDefault();
    }
}