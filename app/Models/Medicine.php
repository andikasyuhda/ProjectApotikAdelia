<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_obat',
        'stok',
        'lokasi',
    ];

    // Stock thresholds (single source of truth)
    const STOK_RENDAH = 10;  // < 10
    const STOK_TINGGI = 20;  // > 20

    /**
     * Auto-set lokasi based on first letter of nama_obat.
     */
    protected static function booted(): void
    {
        static::saving(function (Medicine $medicine) {
            if ($medicine->nama_obat) {
                $medicine->lokasi = 'Rak ' . strtoupper(substr(trim($medicine->nama_obat), 0, 1));
            }
        });
    }

    public function getStockStatusAttribute(): string
    {
        if ($this->stok > self::STOK_TINGGI) {
            return 'tinggi';
        } elseif ($this->stok >= self::STOK_RENDAH) {
            return 'sedang';
        } else {
            return 'rendah';
        }
    }

    public function getStockColorAttribute(): string
    {
        return match($this->stock_status) {
            'tinggi' => 'success',
            'sedang' => 'warning',
            'rendah' => 'danger',
            default  => 'secondary',
        };
    }

    public function getStockLabelAttribute(): string
    {
        return match($this->stock_status) {
            'tinggi' => 'Stok Tinggi',
            'sedang' => 'Stok Sedang',
            'rendah' => 'Stok Rendah',
            default  => 'Unknown',
        };
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where('nama_obat', 'like', "%{$search}%")
                         ->orWhere('lokasi', 'like', "%{$search}%");
        }
        return $query;
    }

    public function stockHistories()
    {
        return $this->hasMany(StockHistory::class)->orderBy('created_at', 'desc');
    }
}
