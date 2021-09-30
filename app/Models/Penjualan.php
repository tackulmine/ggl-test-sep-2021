<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
    ];

    public function details()
    {
        return $this->hasMany(PenjualanDetail::class, 'id_penjualan', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function getTotalItemAttribute()
    {
        if ($this->details->isEmpty()) {
            return 0;
        }

        return $this->details->sum('total_barang');
    }
}
