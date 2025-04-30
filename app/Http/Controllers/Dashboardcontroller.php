<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Historylog;
use App\Models\Rak;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Dashboardcontroller extends Controller
{
    public function index(Request $request)
    {
        $totalDokumen = Dokumen::count();
        $totalSize = Dokumen::sum('size') / (1024 * 1024);
        $listRak = Rak::all();

        // Query data untuk grafik
        $data = Dokumen::selectRaw('YEAR(tanggal_laporan) as tahun, kategori, COUNT(*) as jumlah')
            ->groupBy('tahun', 'kategori')
            ->orderBy('tahun')
            ->get();

        // Format data untuk grafik
        $categories = $data->pluck('tahun')->unique()->toArray();
        $curasData = [];
        $curatData = [];
        $curanmorData = [];

        // Isi data berdasarkan tahun
        foreach ($categories as $tahun) {
            $curasData[] = $data->where('tahun', $tahun)->where('kategori', 'curas')->sum('jumlah');
            $curatData[] = $data->where('tahun', $tahun)->where('kategori', 'curat')->sum('jumlah');
            $curanmorData[] = $data->where('tahun', $tahun)->where('kategori', 'curanmor')->sum('jumlah');
        }
        // Buat chart
        $chart = (new LarapexChart)
            ->setType('bar') // Gunakan 'bar' bukan 'donut'
            ->setTitle('Grafik Jumlah Dokumen')
            ->setXAxis($categories)
            ->setDataset([
                [
                    'name' => 'CURAS',
                    'data' => $curasData
                ],
                [
                    'name' => 'CURAT',
                    'data' => $curatData
                ],
                [
                    'name' => 'CURANMOR',
                    'data' => $curanmorData
                ],
            ])
            ->setHeight(200)
            ->setColors(['#FFC107', '#DC3545', '#28A745']);

        // Ambil data lainnya
        $search = $request->input('search');
        $jenis_surat = $request->input('jenis_surat');

        $query = Dokumen::query();

        if (!empty($jenis_surat)) {
            $query->where('jenis_surat', $jenis_surat);
        }
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('lp', 'LIKE', "%$search%")
                    ->orWhere('lp', 'LIKE', "%$search%");
            });
        }

        if ($request->has('sort') && $request->has('direction')) {
            $query->orderBy($request->get('sort'), $request->get('direction'));
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $dokumens = $query->paginate(8);
        $listJenisSurat = Dokumen::select('jenis_surat')->distinct()->pluck('jenis_surat');


        return view('dashboard', compact('totalDokumen', 'totalSize', 'dokumens', 'jenis_surat', 'listJenisSurat', 'chart', 'listRak'));
    }
}
