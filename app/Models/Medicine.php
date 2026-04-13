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

    /**
     * Get the stock status based on quantity
     * 
     * @return string
     */
    public function getStockStatusAttribute()
    {
        if ($this->stok <= 10) {
            return 'rendah';
        } elseif ($this->stok <= 20) {
            return 'sedang';
        } else {
            return 'tinggi';
        }
    }

    /**
     * Get the stock status color
     * 
     * @return string
     */
    public function getStockColorAttribute()
    {
        return match($this->stock_status) {
            'tinggi' => 'success',
            'sedang' => 'warning',
            'rendah' => 'danger',
            default => 'secondary',
        };
    }

    /**
     * Get the stock status label
     * 
     * @return string
     */
    public function getStockLabelAttribute()
    {
        return match($this->stock_status) {
            'tinggi' => 'Stok Tinggi',
            'sedang' => 'Stok Sedang',
            'rendah' => 'Stok Rendah',
            default => 'Unknown',
        };
    }

    /**
     * Search medicines by name or location
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where('nama_obat', 'like', "%{$search}%")
                        ->orWhere('lokasi', 'like', "%{$search}%");
        }
        
        return $query;
    }
}
