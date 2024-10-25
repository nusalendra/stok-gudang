<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    use HasFactory;
    protected $table = 'barang_keluars';
    protected $primarykey = 'id';
    protected $fillable = ['barang_id', 'karyawan_id', 'status_penjualan', 'harga_jual', 'jumlah', 'pendapatan'];
    protected $guraded = [];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }
}
