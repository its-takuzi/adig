<?php

namespace App\Http\Controllers;

use App\Models\dokumen;
use App\Models\Historylog;
use App\Models\Rak;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;
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
            $query->where('lp', '=', $search);

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
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak');
        }

        // Validasi awal (tanggal sebagai string karena format custom)
        $request->validate([
            'lp' => 'required|string|max:255',
            'tanggal_laporan' => 'required|string',
            'kategori' => 'required|in:curas,curat,curanmor',
            'jenis_surat' => 'required|string|max:255',
            'rak_id' => 'required|exists:rak,id',
            'file' => 'required|mimes:pdf,xlsx,docx|max:5120',
            'tanggal_ungkap' => 'nullable|string',
            'pelapor' => 'required|in:tni/polisi,warga',
        ]);

        if (!$request->hasFile('file')) {
            return back()->with('error', 'File tidak ditemukan!');
        }

        // Konversi tanggal dari format d/m/Y ke Y-m-d
        try {
            $tanggalLaporan = Carbon::createFromFormat('d/m/Y', $request->tanggal_laporan)->format('Y-m-d');
            $tanggalUngkap = $request->tanggal_ungkap
                ? Carbon::createFromFormat('d/m/Y', $request->tanggal_ungkap)->format('Y-m-d')
                : null;
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Format tanggal tidak valid. Gunakan format dd/mm/yyyy.');
        }

        // Ambil tahun dan bulan romawi dari tanggal laporan
        $tahun_laporan = date('Y', strtotime($tanggalLaporan));
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
        $bulan = date('m', strtotime($tanggalLaporan));
        $bulan_romawi_format = $bulan_romawi[$bulan];
        $pelaporFormatted = strtoupper($request->pelapor == 'tni/polisi' ? 'A' : 'B');

        // Format nomor LP otomatis
        $nomor_lp_formatted = "LP/" . $pelaporFormatted . "/" . $request->lp . "/" . $bulan_romawi_format . "/" . $tahun_laporan . "/SPKT/POLSEK DUMAI TIMUR/POLRES DUMAI/POLDA RIAU";

        // Simpan file
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $path = $file->storeAs('files', $fileName, 'public');
        $size = $file->getSize();

        // Cek duplikasi
        $existing = Dokumen::where('laporan_polisi', $nomor_lp_formatted)
            ->where('kategori', $request->kategori)
            ->where('jenis_surat', $request->jenis_surat)
            ->first();

        if ($existing) {
            return back()->withInput()->with('error', 'Dokumen dengan kombinasi yang sama sudah ada!');
        }

        try {
            // Simpan ke database
            $dokumen = Dokumen::create([
                'user_id' => Auth::id(),
                'lp' => $request->lp,
                'laporan_polisi' => $nomor_lp_formatted,
                'tanggal_laporan' => $tanggalLaporan,
                'kategori' => $request->kategori,
                'jenis_surat' => $request->jenis_surat,
                'rak_id' => $request->rak_id,
                'tanggal_ungkap' => $tanggalUngkap,
                'file' => $path,
                'size' => $size,
            ]);

            // Simpan ke history log
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
        // dd($request->all());
        $dokumen = Dokumen::findOrFail($id);

        if (Auth::user()->role !== 'admin') {
            return redirect()->back()->with([
                'status_code' => 403,
                'error_message' => 'Akses ditolak!'
            ]);
        }

        // Validasi: tanggal sebagai string karena format custom
        $request->validate([
            'laporan_polisi' => 'required|string|max:255',
            'tanggal_laporan' => 'required|string',
            'kategori' => 'required|in:curas,curat,curanmor',
            'jenis_surat' => 'required|string|max:255',
            'rak_id' => 'required|exists:rak,id',
            'tanggal_ungkap' => 'nullable|string',
            'file' => 'nullable|mimes:pdf,xlsx,docx|max:5120',
            'pelapor' => 'required|in:tni/polisi,warga',
        ]);
        try {
            $tanggalLaporan = preg_match('/\d{2}\/\d{2}\/\d{4}/', $request->tanggal_laporan)
                ? Carbon::createFromFormat('d/m/Y', $request->tanggal_laporan)->format('Y-m-d')
                : $request->tanggal_laporan;

            $tanggalUngkap = !empty($request->tanggal_ungkap) && preg_match('/\d{2}\/\d{2}\/\d{4}/', $request->tanggal_ungkap)
                ? Carbon::createFromFormat('d/m/Y', $request->tanggal_ungkap)->format('Y-m-d')
                : $request->tanggal_ungkap;
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Format tanggal tidak valid. Gunakan format dd/mm/yyyy.');
        }


        // Format ulang laporan polisi
        $tahun_laporan = date('Y', strtotime($tanggalLaporan));
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
        $bulan = date('m', strtotime($tanggalLaporan));
        $bulan_romawi_format = $bulan_romawi[$bulan];
        $pelaporFormatted = strtoupper($request->pelapor == 'tni/polisi' ? 'A' : 'B');

        $nomor_lp_formatted = "LP/" . $pelaporFormatted . "/" . $request->laporan_polisi . "/" . $bulan_romawi_format . "/" . $tahun_laporan . "/SPKT/POLSEK DUMAI TIMUR/POLRES DUMAI/POLDA RIAU";

        // Siapkan data untuk update
        $updateData = [
            //  'laporan_polisi' => $nomor_lp_formatted,
            'tanggal_laporan' => $tanggalLaporan,
            'kategori' => $request->kategori,
            'jenis_surat' => $request->jenis_surat,
            'rak_id' => $request->rak_id,
            'tanggal_ungkap' => $tanggalUngkap,
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

        if (Auth::user()->role !== 'admin') { // ini jas
            abort(403, 'Akses ditolak'); // ini jas
        }

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
