<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BarangKeluarController extends Controller
{

    public function index()
    {
        return view('content.pages.karyawan.barang-keluar.index');
    }
}
