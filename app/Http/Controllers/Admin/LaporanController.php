<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Pesanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

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
            ->join('pembelian_pesanan', 'pembelian_pesanan.pesanan_id', '=', 'pesanans.id')
            ->join('pembelians', 'pembelians.id', '=', 'pembelian_pesanan.pembelian_id')
            ->where('pembelians.status_pembelian', 'Sukses')
            ->whereDate('pesanans.created_at', $tanggal)
            ->groupBy('barangs.nama', 'barangs.ukuran', 'barangs.warna', 'pesanans.harga')
            ->get();

        return view('content.pages.admin.laporan.index', compact('data', 'tanggal'));
    }

    public function cetakPDF(Request $request)
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
            ->join('pembelian_pesanan', 'pembelian_pesanan.pesanan_id', '=', 'pesanans.id')
            ->join('pembelians', 'pembelians.id', '=', 'pembelian_pesanan.pembelian_id')
            ->where('pembelians.status_pembelian', 'Sukses')
            ->whereDate('pesanans.created_at', $tanggal)
            ->groupBy('barangs.nama', 'barangs.ukuran', 'barangs.warna', 'pesanans.harga')
            ->get();

        $pdf = FacadePdf::loadView('content.pages.admin.laporan.cetak-laporan-pdf', [
            'title' => 'Laporan Hari Ini',
            'pesanan' => $data,
            'tanggal' => $tanggal
        ]);

        $pdf->setPaper('A4', 'potrait');

        return $pdf->stream('report-online.pdf');
    }
}
