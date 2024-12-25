<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;

class BarangController extends Controller
{
    public function index()
    {
        $data = Barang::with('pesanan')->get();

        foreach ($data as $item) {
            $totalStokKeluar = $item->pesanan->sum('qty');
            $pendapatan = $item->pesanan->sum('pendapatan');
            $item->total_stok_keluar = $totalStokKeluar;
            $item->pendapatan = $pendapatan;
        }

        return view('content.pages.admin.barang.index', compact('data'));
    }

    public function hasilKlasifikasiPerhitungan()
    {

        $barang = Barang::all();
        $totalPendapatan = 0;
        $dataBarang = [];

        foreach ($barang as $item) {
            $stokTerjualNormal = $item->pesanan->where('status_penjualan', 'Normal')->sum('qty');
            $stokTerjualObral = $item->pesanan->where('status_penjualan', 'Obral')->sum('qty');

            $pendapatan = $item->pesanan->sum('pendapatan');
            $totalPendapatan += $pendapatan;

            $dataBarang[] = [
                'nama' => $item->nama . ' (Ukuran ' . $item->ukuran . ', Warna ' . $item->warna . ')',
                'stok_terjual_normal' => $stokTerjualNormal,
                'harga_normal' => $item->harga_jual,
                'stok_terjual_obral' => $stokTerjualObral,
                'harga_obral' => $item->harga_jual / 2,
                'pendapatan' => $pendapatan,
            ];
        }

        foreach ($dataBarang as &$data) {
            $data['persentase'] = round(($data['pendapatan'] / $totalPendapatan) * 100, 2);
        }

        usort($dataBarang, function ($a, $b) {
            return $b['persentase'] <=> $a['persentase'];
        });

        $nilaiKumulatif = 0;

        foreach ($dataBarang as &$data) {
            $nilaiKumulatif += $data['persentase'];
            $data['kumulatif'] = round($nilaiKumulatif, 2);
        }

        return view('content.pages.admin.barang.hasil-klasifikasi-perhitungan', compact('dataBarang', 'totalPendapatan'));
    }

    public function destroy($id)
    {
        $barang = Barang::find($id);
        $barang->delete();

        return redirect('/barang');
    }
}
