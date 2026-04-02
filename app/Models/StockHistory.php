<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_id',
        'user_id',
        'previous_stock',
        'new_stock',
        'change_amount',
        'change_type',
        'notes',
    ];

    /**
     * Get the medicine that this history belongs to.
     */
    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    /**
     * Get the user who made this change.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get a human-readable change type label.
     */
    public function getChangeTypeLabelAttribute()
    {
        return match($this->change_type) {
            'in' => 'Stok Masuk',
            'out' => 'Stok Keluar',
            'adjust' => 'Penyesuaian',
            default => 'Unknown',
        };
    }

    /**
     * Get the change type color for styling.
     */
    public function getChangeTypeColorAttribute()
    {
        return match($this->change_type) {
            'in' => 'success',
            'out' => 'danger',
            'adjust' => 'warning',
            default => 'secondary',
        };
    }
}
