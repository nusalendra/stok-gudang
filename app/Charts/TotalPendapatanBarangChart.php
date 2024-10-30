<?php

namespace App\Charts;

use App\Models\Barang;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class TotalPendapatanBarangChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $barang = Barang::all();

        $namaBarang = [];
        $pendapatanBarang = [];

        foreach ($barang as $item) {
            $namaBarang[] = $item->nama;
            $pendapatanBarang[] = $item->barangKeluar->sum('pendapatan');
        }
        return $this->chart->barChart()
            ->setTitle('Chart Total Pendapatan Barang')
            ->setSubtitle('Menampilkan total pendapatan setiap barang')
            ->addData('Total Pendapatan', $pendapatanBarang)
            ->setXAxis($namaBarang);
    }
}
