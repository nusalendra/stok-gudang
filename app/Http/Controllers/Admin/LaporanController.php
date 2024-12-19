<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\Pesanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal', Carbon::now()->toDateString());

        $data = Pesanan::select(
            'barangs.nama',
            'barangs.ukuran',
            'barangs.warna',
            DB::raw('SUM(pesanans.qty) as total_qty'),
            'pesanans.harga'
        )
            ->join('barangs', 'barangs.id', '=', 'pesanans.barang_id')
            ->whereDate('pesanans.created_at', $tanggal)
            ->groupBy('barangs.nama', 'barangs.ukuran', 'barangs.warna', 'pesanans.harga')
            ->get();

        return view('content.pages.admin.laporan.index', compact('data', 'tanggal'));
    }
}
