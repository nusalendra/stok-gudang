<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangMasukController extends Controller
{
    public function index()
    {
        $data = BarangMasuk::all();
        return view('content.pages.karyawan.barang-masuk.index', compact('data'));
    }

    public function barangBaru()
    {
        $supplier = Supplier::all();
        return view('content.pages.karyawan.barang-masuk.barang-baru', compact('supplier'));
    }

    public function barangBaruStore(Request $request)
    {
        $user = Auth::user();
        $barang = new Barang();
        $barang->nama = $request->nama;
        $barang->ukuran = $request->ukuran;
        $barang->warna = $request->warna;
        $barang->harga_beli = $request->harga_beli;

        $persentaseKeuntungan = $request->persentase_harga_jual / 100;
        $keuntungan = $barang->harga_beli + ($barang->harga_beli * $persentaseKeuntungan);
        $barang->harga_jual = $keuntungan;

        $barang->stok = $request->jumlah;
        $barang->tanggal_expired = $request->tanggal_expired;
        $barang->save();

        $barangMasuk = new BarangMasuk();
        $barangMasuk->barang_id = $barang->id;
        $barangMasuk->supplier_id = $request->supplier_id;
        $barangMasuk->karyawan_id = $user->karyawan->id;
        $barangMasuk->jumlah = $request->jumlah;
        $barangMasuk->deskripsi = $request->deskripsi;
        $barangMasuk->save();

        return redirect('/barang-masuk');
    }

    public function barangTersedia()
    {
        $barang = Barang::all();
        $supplier = Supplier::all();
        return view('content.pages.karyawan.barang-masuk.barang-tersedia', compact('barang', 'supplier'));
    }

    public function barangTersediaStore(Request $request)
    {
        $user = Auth::user();

        $barang = Barang::find($request->barang_id);
        $barang->harga_beli = $request->harga_beli;

        $persentaseKeuntungan = $request->persentase_harga_jual / 100;
        $keuntungan = $barang->harga_beli + ($barang->harga_beli * $persentaseKeuntungan);
        $barang->harga_jual = $keuntungan;
        $barang->stok += $request->jumlah;
        $barang->tanggal_expired = $request->tanggal_expired ?? $barang->tanggal_expired;
        $barang->save();

        $barangMasuk = new BarangMasuk();
        $barangMasuk->barang_id = $barang->id;
        $barangMasuk->supplier_id = $request->supplier_id;
        $barangMasuk->karyawan_id = $user->karyawan->id;
        $barangMasuk->jumlah = $request->jumlah;
        $barangMasuk->deskripsi = $request->deskripsi;
        $barangMasuk->save();

        return redirect('/barang-masuk');
    }
}
