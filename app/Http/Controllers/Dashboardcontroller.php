<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Historylog;
use App\Models\Rak;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Dashboardcontroller extends Controller
{
    public function index(Request $request)
    {
        $totalDokumen = Dokumen::count();
        $totalSize = Dokumen::sum('size') / (1024 * 1024);
        $listRak = Rak::all();

        // Ambil semua data tahun laporan unik
        $semuaTahun = Dokumen::selectRaw('YEAR(tanggal_laporan) as tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        $groupedTahun = $semuaTahun->chunk(3);

        // Ambil 3 tahun terbaru sebagai default
        $tahunTerbaru = $semuaTahun->take(3)->sort()->values();

        // Ambil input filter tahun (GET), jika tidak ada gunakan 3 tahun terbaru
        $tahunFilter = collect($request->input('tahun', []));

        // Ambil data grafik hanya untuk tahun terpilih
        $data = Dokumen::selectRaw('YEAR(tanggal_laporan) as tahun, kategori, COUNT(*) as jumlah')
            ->whereIn(DB::raw('YEAR(tanggal_laporan)'), $tahunFilter)
            ->groupBy('tahun', 'kategori')
            ->orderBy('tahun')
            ->get();

        $categories = $tahunFilter->sort()->values();
        $curasData = [];
        $curatData = [];
        $curanmorData = [];

        foreach ($categories as $tahun) {
            $curasData[] = $data->where('tahun', $tahun)->where('kategori', 'CURAS')->sum('jumlah');
            $curatData[] = $data->where('tahun', $tahun)->where('kategori', 'CURAT')->sum('jumlah');
            $curanmorData[] = $data->where('tahun', $tahun)->where('kategori', 'CURANMOR')->sum('jumlah');
        }

        // Filter dan data tabel
        $search = $request->input('search');
        $jenis_surat = $request->input('jenis_surat');
        $query = Dokumen::query();

        if (!empty($jenis_surat)) {
            $query->where('jenis_surat', $jenis_surat);
        }
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('lp', 'LIKE', "%$search%");
            });
        }

        if ($request->has('sort') && $request->has('direction')) {
            $query->orderBy($request->get('sort'), $request->get('direction'));
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $dokumens = $query->paginate(8);
        $listJenisSurat = Dokumen::select('jenis_surat')->distinct()->pluck('jenis_surat');

        return view('dashboard', compact(
            'totalDokumen',
            'totalSize',
            'dokumens',
            'jenis_surat',
            'listJenisSurat',
            'listRak',
            'categories',
            'curasData',
            'curatData',
            'curanmorData',
            'semuaTahun',
            'tahunFilter',
            'groupedTahun', // tambahkan ini
        ));
    }
}
