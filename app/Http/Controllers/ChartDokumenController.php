<?php

namespace App\Http\Controllers;

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

        $tahunList = $chartData->pluck('tahun')->unique()->values();

        $kategoriList = ['CURAS', 'CURAT', 'CURANMOR'];

        $dataKategori = [];
        foreach ($kategoriList as $kategori) {
            $dataKategori[] = [
                'label' => strtoupper($kategori),
                'data' => $tahunList->map(function ($tahun) use ($chartData, $kategori) {
                    return $chartData->where('tahun', $tahun)->where('kategori', $kategori)->sum('total');
                }),
                'backgroundColor' => match ($kategori) {
                    'CURAS' => '#FFC107',
                    'CURAT' => '#E63946',
                    'CURANMOR' => '#2A9D8F',
                    default => '#ccc'
                },
            ];
        }

        return view('charts.index', [
            'tahunList' => $tahunList,
            'dataKategori' => $dataKategori
        ]);
    }
}
