<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barangs';
    protected $primarykey = 'id';
    protected $fillable = ['nama', 'ukuran', 'warna', 'harga_beli', 'harga_jual', 'deskripsi', 'stok', 'total_stok_keluar'];
    protected $guraded = [];

    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'barang_id');
    }

    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluar::class, 'barang_id');
    }
}
