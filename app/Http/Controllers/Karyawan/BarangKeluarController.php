<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangKeluarController extends Controller
{

    public function index()
    {
        $data = BarangKeluar::all();
        return view('content.pages.karyawan.barang-keluar.index', compact('data'));
    }

    public function create()
    {
        $barang = Barang::all();
        return view('content.pages.karyawan.barang-keluar.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $barang = Barang::find($request->barang_id);

        if ($barang->stok < $request->jumlah) {
            return redirect()->back()->with('error', 'Jumlah barang yang dikeluarkan melebihi stok yang tersedia');
        }
        $barang->stok -= $request->jumlah;
        $barang->total_stok_keluar += $request->jumlah;
        $barang->save();

        $barangKeluar = new BarangKeluar();
        $barangKeluar->barang_id = $barang->id;
        $barangKeluar->karyawan_id = $user->karyawan->id;
        $barangKeluar->jumlah = $request->jumlah;
        $barangKeluar->save();
    }
}
