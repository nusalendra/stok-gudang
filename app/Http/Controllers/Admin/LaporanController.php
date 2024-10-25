<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangKeluar;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $data = Barang::with('barangKeluar')->get();

        foreach ($data as $item) {
            $stokKeluarHarian = BarangKeluar::where('barang_id', $item->id)
                ->whereDate('created_at', Carbon::now()->toDateString())
                ->sum('jumlah');

            $pendapatanHarian = BarangKeluar::where('barang_id', $item->id)
                ->whereDate('created_at', Carbon::now()->toDateString())
                ->sum('pendapatan');

            $item->stok_keluar_harian = $stokKeluarHarian;
            $item->pendapatan_harian = $pendapatanHarian;
        }
        return view('content.pages.admin.laporan.index', compact('data'));
    }
}
