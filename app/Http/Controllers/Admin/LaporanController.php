<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangKeluar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal', Carbon::now()->toDateString());

        $data = BarangKeluar::select(
            'barangs.nama',
            'barangs.ukuran',
            'barangs.warna',
            'barang_keluars.status_penjualan',
            'barang_keluars.harga_jual',
            DB::raw('SUM(barang_keluars.jumlah) as total_jumlah'),
            DB::raw('SUM(barang_keluars.pendapatan) as total_pendapatan')
        )
            ->join('barangs', 'barangs.id', '=', 'barang_keluars.barang_id')
            ->whereDate('barang_keluars.created_at', $tanggal)
            ->groupBy('barangs.nama', 'barangs.ukuran', 'barangs.warna', 'barang_keluars.status_penjualan', 'barang_keluars.harga_jual')
            ->get();

        return view('content.pages.admin.laporan.index', compact('data', 'tanggal'));
    }
}
