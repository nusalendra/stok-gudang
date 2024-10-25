<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BarangController extends Controller
{
    public function index()
    {
        $data = Barang::with('barangKeluar')->get();

        foreach ($data as $item) {
            $totalStokKeluar = $item->barangKeluar->sum('jumlah');
            $pendapatan = $item->barangKeluar->sum('pendapatan');
            $item->total_stok_keluar = $totalStokKeluar;
            $item->pendapatan = $pendapatan;
        }
        // dd($data);
        return view('content.pages.admin.barang.index', compact('data'));
    }

    public function klasifikasiPerhitungan(Request $request)
    {
        // Persentase Kelas ABC
        $kelasA = $request->input('kelasA');
        $kelasB = $request->input('kelasB');
        $kelasC = $request->input('kelasC');

        $barang = Barang::all();
        $totalPendapatan = 0;
        $dataBarang = [];

        foreach ($barang as $item) {
            $pendapatan = $item->total_stok_keluar * $item->harga_jual;
            $totalPendapatan += $pendapatan;

            $dataBarang[] = [
                'nama' => $item->nama . ' (Ukuran ' . $item->ukuran . ', Warna ' . $item->warna . ')',
                'stok_terjual' => $item->total_stok_keluar,
                'harga' => $item->harga_jual,
                'pendapatan' => $pendapatan
            ];
        }

        foreach ($dataBarang as &$data) {
            $data['persentase'] = round(($data['pendapatan'] / $totalPendapatan) * 100, 2);
        }

        $dataHitungPersentase = $dataBarang;
        Log::info($dataHitungPersentase);
        $dataHitungKumulatif = $dataBarang;

        usort($dataHitungKumulatif, function ($a, $b) {
            return $b['persentase'] <=> $a['persentase'];
        });

        $kelasAData = [];
        $kelasBData = [];
        $kelasCData = [];

        $nilaiKumulatif = 0;

        foreach ($dataHitungKumulatif as &$data) {
            $nilaiKumulatif += $data['persentase'];
            $data['kumulatif'] = round($nilaiKumulatif, 2);

            // Pengelompokan berdasarkan nilai kumulatif
            if ($nilaiKumulatif <= $kelasA) {
                $kelasAData[] = $data;
            } elseif ($nilaiKumulatif <= ($kelasA + $kelasB)) {
                $kelasBData[] = $data;
            } else {
                $kelasCData[] = $data;
            }
        }

        session([
            'kelasA' => $request->input('kelasA'),
            'kelasB' => $request->input('kelasB'),
            'kelasC' => $request->input('kelasC'),
            'dataHitungPersentase' => $dataHitungPersentase,
            'dataHitungKumulatif' => $dataHitungKumulatif,
            'kelasAData' => $kelasAData,
            'kelasBData' => $kelasBData,
            'kelasCData' => $kelasCData,
        ]);

        // Redirect ke halaman hasil
        return redirect('/barang/hasil-klasifikasi-perhitungan');
    }

    public function hasilKlasifikasiPerhitungan()
    {
        $kelasA = session('kelasA');
        $kelasB = session('kelasB');
        $kelasC = session('kelasC');
        $dataHitungPersentase = session('dataHitungPersentase', []);
        $dataHitungKumulatif = session('dataHitungKumulatif', []);
        $kelasAData = session('kelasAData', []);
        $kelasBData = session('kelasBData', []);
        $kelasCData = session('kelasCData', []);

        return view('content.pages.admin.barang.hasil-klasifikasi-perhitungan', compact('kelasA', 'kelasB', 'kelasC', 'dataHitungPersentase', 'dataHitungKumulatif', 'kelasAData', 'kelasBData', 'kelasCData'));
    }

    public function destroy($id)
    {
        $barang = Barang::find($id);
        $barang->delete();

        return redirect('/barang');
    }
}
