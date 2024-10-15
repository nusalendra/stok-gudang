<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;
    protected $table = 'karyawans';
    protected $primarykey = 'id';
    protected $fillable = ['user_id', 'nama_lengkap', 'jenis_kelamin', 'umur', 'nomor_telepon'];
    protected $guraded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
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
