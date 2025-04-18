<?php

namespace App\Http\Controllers;

use App\Models\dokumen;
use App\Models\Historylog;
use App\Models\Rak;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage as FacadesStorage;

class DokumenController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $kategori = $request->input('kategori', 'curas');
        $query = Dokumen::query();


        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('laporan_polisi', 'LIKE', "%$search%")
                    ->orWhere('tanggal_laporan', 'LIKE', "%$search%");
            });
            $firstResult = $query->first();
            if ($firstResult) {
                $kategori = $firstResult->kategori;
            }
        } else {
            $query->where('kategori', $kategori);
        }

        if ($request->has('sort') && $request->has('direction')) {
            $query->orderBy($request->get('sort'), $request->get('direction'));
        } else {
            $query->orderBy('created_at', 'desc');
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_laporan', $request->tahun);
        }
        $listTahun = Dokumen::selectRaw('YEAR(tanggal_laporan) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        $dokumens = $query->paginate(8);
        $listKategori = Dokumen::select('kategori')->distinct()->pluck('kategori');

        return view('arsip', compact('dokumens', 'kategori', 'listKategori', 'listTahun'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'laporan_polisi' => 'required|string|max:255',
            'tanggal_laporan' => 'required|date',
            'kategori' => 'required|in:curas,curat,curanmor',
            'jenis_surat' => 'required|string|max:255',
            'rak_id' => 'required|exists:rak,id',
            'file' => 'required|mimes:pdf,xlsx,docx|max:5120',
            'tanggal_ungkap' => 'nullable|date',
            'pelapor' => 'required|in:tni/polisi,warga',

        ]);
        if (!$request->hasFile('file')) {
            return back()->with('error', 'File tidak ditemukan!');
        }


        // Ambil tahun dari tanggal laporan
        $tahun_laporan = date('Y', strtotime($request->tanggal_laporan));


        // Format bulan dalam angka romawi
        $bulan_romawi = [
            '01' => 'I',
            '02' => 'II',
            '03' => 'III',
            '04' => 'IV',
            '05' => 'V',
            '06' => 'VI',
            '07' => 'VII',
            '08' => 'VIII',
            '09' => 'IX',
            '10' => 'X',
            '11' => 'XI',
            '12' => 'XII'
        ];
        $bulan = date('m', strtotime($request->tanggal_laporan));
        $bulan_romawi_format = $bulan_romawi[$bulan];
        $pelaporFormatted = strtoupper($request->pelapor == 'tni/polisi' ? 'A' : 'B');

        // format nomor LP otomatis
        $nomor_lp_formatted = "LP/" . $pelaporFormatted . "/" . $request->laporan_polisi . "/" . $bulan_romawi_format . "/" . $tahun_laporan . "/SPKT/POLSEK DUMAI TIMUR/POLRES DUMAI/POLDA RIAU";


        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $path = $file->storeAs('files', $fileName, 'public');
        $size = $file->getSize();

        $existing = Dokumen::where('laporan_polisi', $nomor_lp_formatted)
            ->where('kategori', $request->kategori)
            ->where('jenis_surat', $request->jenis_surat)
            // ->where('pelapor', $request->pelapor)
            ->first();

        if ($existing) {
            return back()->withInput()->with('error', 'Dokumen dengan kombinasi yang sama sudah ada!');
        }

        try {
            $dokumen = Dokumen::create([
                'user_id' => Auth::id(),
                'laporan_polisi' => $nomor_lp_formatted,
                'tanggal_laporan' => $request->tanggal_laporan,
                'kategori' => $request->kategori,
                'jenis_surat' => $request->jenis_surat,
                'rak_id' => $request->rak_id,
                'tanggal_ungkap' => $request->tanggal_ungkap,
                'file' => $path,
                'size' => $size,
            ]);

            // simpan ke history log
            Historylog::create([
                'user_id' => Auth::id(),
                'file_id' => $dokumen->id,
                'action' => 'upload',
                'timestamp' => now(),
            ]);

            return redirect()->route('arsip.index')->with('success', 'Berkas berhasil ditambahkan.')->with('previewData', $dokumen);
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return back()->withInput()->with('error', 'Nomor Laporan Polisi sudah ada dalam sistem!');
            }

            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function download($id)
    {
        $dokumen = dokumen::findorfail($id);

        if (!$dokumen->file || !Storage::exists('public' . $dokumen->file)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        //simpan ke history log
        Historylog::create([
            'user_id' => Auth::id(),
            'file_id' => $dokumen->id,
            'action' => 'download',
            'timestamp' => now(),
        ]);
        return Storage::download('public' . $dokumen->file, basename($dokumen->file));
    }


    public function detail($id)
    {
        $dokumen = Dokumen::with(['user', 'rak'])->findOrFail($id);

        return response()->json([
            'laporan_polisi' => $dokumen->laporan_polisi,
            'kategori' => $dokumen->kategori,
            'jenis_surat' => $dokumen->jenis_surat,
            'tanggal_laporan' => $dokumen->tanggal_laporan,
            'tanggal_ungkap' => optional($dokumen->tanggal_ungkap)->format('d/m/Y'),
            'rak' => $dokumen->rak->nama_rak ?? 'Tidak diketahui',
            'file' => $dokumen->file,
            'uploaded_at' => optional($dokumen->created_at)->translatedFormat('d F Y'),
            'uploader' => [
                'nama' => $dokumen->user->name ?? 'Tidak diketahui',
                'foto_url' => asset('storage/profile/' . ($dokumen->user->pp ?? 'default.jpg')),
            ],
        ]);
    }

    public function update(Request $request, $id)
    {
        $dokumen = Dokumen::findOrFail($id);

        $request->validate([
            'laporan_polisi' => 'required|string|max:255',
            'tanggal_laporan' => 'required|date',
            'kategori' => 'required|in:curas,curat,curanmor',
            'jenis_surat' => 'required|string|max:255',
            'rak_id' => 'required|exists:rak,id',
            'tanggal_ungkap' => 'nullable|date',
            'file' => 'nullable|mimes:pdf,xlsx,docx|max:5120',
            'pelapor' => 'required|in:tni/polisi,warga',
        ]);

        // Format ulang laporan polisi
        $tahun_laporan = date('Y', strtotime($request->tanggal_laporan));
        $bulan_romawi = [
            '01' => 'I',
            '02' => 'II',
            '03' => 'III',
            '04' => 'IV',
            '05' => 'V',
            '06' => 'VI',
            '07' => 'VII',
            '08' => 'VIII',
            '09' => 'IX',
            '10' => 'X',
            '11' => 'XI',
            '12' => 'XII'
        ];
        $bulan = date('m', strtotime($request->tanggal_laporan));
        $bulan_romawi_format = $bulan_romawi[$bulan];
        $pelaporFormatted = strtoupper($request->pelapor == 'tni/polisi' ? 'A' : 'B');

        $nomor_lp_formatted = "LP/" . $pelaporFormatted . "/" . $request->laporan_polisi . "/" . $bulan_romawi_format . "/" . $tahun_laporan . "/SPKT/POLSEK DUMAI TIMUR/POLRES DUMAI/POLDA RIAU";

        $updateData = [
            // 'laporan_polisi' => $nomor_lp_formatted,
            'tanggal_laporan' => $request->tanggal_laporan,
            'kategori' => $request->kategori,
            'jenis_surat' => $request->jenis_surat,
            'rak_id' => $request->rak_id,
            'tanggal_ungkap' => $request->tanggal_ungkap,
        ];

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $path = $file->storeAs('files', $fileName, 'public');
            $size = $file->getSize();

            $updateData['file'] = $path;
            $updateData['size'] = $size;
        }

        $dokumen->update($updateData);

        Historylog::create([
            'user_id' => Auth::id(),
            'file_id' => $dokumen->id,
            'action' => 'edit',
            'timestamp' => now(),
        ]);

        return redirect()->back()->with('success', 'Dokumen berhasil diperbarui!');
    }

    public function destroy(string $id): RedirectResponse
    {
        $dokumen = Dokumen::findOrFail($id);

        // Simpan history log sebelum dokumen dihapus
        Historylog::create([
            'user_id' => Auth::id(),
            'file_id' => $dokumen->id,
            'action' => 'delete',
            'timestamp' => now(),
        ]);

        // Gunakan soft delete
        $dokumen->delete();

        return redirect()->back()->with('success', 'Dokumen berhasil dihapus.');
    }
}
