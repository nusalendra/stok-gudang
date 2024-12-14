<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;
    protected $table = 'pesanans';
    protected $primarykey = 'id';
    protected $fillable = ['barang_id', 'qty', 'harga'];
    protected $guraded = [];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function pembelian()
    {
        return $this->belongsToMany(Pembelian::class);
    }

    public function pembelianPesanan()
    {
        return $this->belongsToMany(PembelianPesanan::class, 'pembelian_pesanan', 'pesanan_id', 'pembelian_id');
    }
}
