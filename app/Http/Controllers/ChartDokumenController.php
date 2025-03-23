<?php

namespace App\Http\Controllers;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class ChartDokumenController extends Controller
{
    public function index()
    {

        $chartData = DB::table('dokumen')
            ->selectRaw('YEAR(tanggal_laporan) as tahun, kategori, COUNT(*) as total')
            ->groupBy('tahun', 'kategori')
            ->orderBy('tahun')
            ->get();

        // Ambil daftar tahun unik dari data
        $tahunList = $chartData->pluck('tahun')->unique()->toArray();

        // Definisi kategori yang ada
        $kategoriList = ['curas', 'curat', 'curanmor'];

        // Format data untuk chart
        $dataKategori = [];
        foreach ($kategoriList as $kategori) {
            $dataKategori[] = [
                'name' => strtoupper($kategori),
                'data' => array_map(function ($tahun) use ($chartData, $kategori) {
                    return $chartData->where('tahun', $tahun)->where('kategori', $kategori)->sum('total') ?? 0;
                }, $tahunList)
            ];
        }

        // Buat grafik dengan Larapex Charts
        $chart = (new LarapexChart)
            ->settype('bar')
            ->setTitle('Grafik Jumlah Dokumen')
            ->setXAxis($tahunList)
            ->setDataset($dataKategori)
            ->setColors(['#FFC107', '#E63946', '#2A9D8F']);

        // Kirim data ke view
        return view('charts.index', compact('chart'));
    }
}
