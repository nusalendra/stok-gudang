<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table = 'suppliers';
    protected $primarykey = 'id';
    protected $fillable = ['nama', 'alamat', 'nomor_telepon'];
    protected $guraded = [];

    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'barang_id');
    }
}
