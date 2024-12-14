<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianPesanan extends Model
{
    use HasFactory;
    protected $table = 'pembelian_pesanan';
    protected $primarykey = 'id';
    protected $fillable = ['pembayaran_id', 'pesanan_Id'];
    protected $guraded = [];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class);
    }

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}
