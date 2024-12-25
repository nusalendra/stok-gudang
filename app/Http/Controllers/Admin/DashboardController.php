<?php

namespace App\Http\Controllers\Admin;

use App\Charts\TotalPendapatanBarangChart;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\Pesanan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(TotalPendapatanBarangChart $totalPendapatanBarangChart)
    {
        $totalBarangMasuk = BarangMasuk::sum('jumlah');
        $totalBarangDibeli = Pesanan::sum('qty');
        $totalBarang = Barang::count();
        $totalBarangExpired = Barang::where('tanggal_expired', '<=', Carbon::today())->count();

        return view('content.dashboard.index', compact('totalBarangMasuk', 'totalBarangDibeli', 'totalBarang', 'totalBarangExpired'), ['totalPendapatanBarangChart' => $totalPendapatanBarangChart->build()]);
    }
}
