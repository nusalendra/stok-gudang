<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barangs';
    protected $primarykey = 'id';
    protected $fillable = ['rak_id', 'nama', 'ukuran', 'warna', 'harga_beli', 'harga_jual', 'stok', 'tanggal_expired'];
    protected $guraded = [];

    public function rak()
    {
        return $this->belongsTo(Rak::class, 'rak_id');
    }

    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'barang_id');
    }

    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluar::class, 'barang_id');
    }
}
