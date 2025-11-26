<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class kir extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'user_id',
        'kib_id',
        'nama_barang',
        'merk',
        'no_seri',
        'ukuran',
        'bahan',
        'tahun_buat',
        'jumlah_barang_register',
        'harga_beli',
        'kondisi_barang',
        'keterangan_mutasi',
    ];

    public function kib()
    {
        return $this->belongsTo(kib::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
