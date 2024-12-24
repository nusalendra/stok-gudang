<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;
    protected $table = 'pembelians';
    protected $primarykey = 'id';
    protected $fillable = ['karyawan_id', 'nama_pembeli', 'status_pembelian', 'metode_pembayaran', 'total_harga'];
    protected $guraded = [];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function pesanan()
    {
        return $this->belongsToMany(Pesanan::class);
    }

    public function pembelianPesanan()
    {
        return $this->belongsToMany(PembelianPesanan::class, 'pembelian_pesanan', 'pembelian_id', 'pesanan_id');
    }
}
