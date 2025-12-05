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
        'kode_barang',
        'tahun',
        'lokasi',
        'kondisi',
        'jumlah',
        'nilai_perolehan',
        'gambar_qr',
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
