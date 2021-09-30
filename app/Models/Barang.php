<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'gambar_barang',
    ];

    public function stoks()
    {
        return $this->hasMany(Stok::class, 'id_barang', 'id');
    }

    public function getStokAttribute()
    {
        if ($this->stoks->isEmpty()) {
            return 0;
        }

        $in = $this->stoks->where('jenis_stok', 'in')->sum('total_barang');
        $out = $this->stoks->where('jenis_stok', 'out')->sum('total_barang');

        return $in - $out;
    }
}
