<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Pembelian;
use Illuminate\Http\Request;

class KeranjangPesananController extends Controller
{
    public function index()
    {
        $data = Pembelian::where('status_pembelian', '=', 'Dalam Keranjang')->get();
        return view('content.pages.karyawan.keranjang-pesanan.index', compact('data'));
    }

    public function show($id)
    {
        $pembeli = Pembelian::find($id);

        return view('content.pages.karyawan.keranjang-pesanan.show', compact('pembeli'));
    }

    public function destroy($id)
    {
        $pembeli = Pembelian::find($id);

        foreach ($pembeli->pesanan as $pesanan) {
            $pesanan->delete();
        }

        $pembeli->delete();

        return redirect('/keranjang-pesanan');
    }
}
