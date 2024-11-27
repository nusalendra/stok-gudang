<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    use HasFactory;
    protected $table = 'raks';
    protected $primarykey = 'id';
    protected $fillable = ['jenis', 'kapasitas'];
    protected $guraded = [];

    public function barang()
    {
        return $this->hasMany(Barang::class, 'rak_id');
    }
}
