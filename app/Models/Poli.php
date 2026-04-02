<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Poli extends Model
{
    use HasFactory;
    protected $fillable =  ['nama', 'biaya', 'keterangan'];

    public function daftar():HasMany
    {
        return $this->hasMany(Daftar::class);
    }
}
