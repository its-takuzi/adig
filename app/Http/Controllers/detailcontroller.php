<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Historylog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class detailcontroller extends Controller
{
    public function hapus(string $id): RedirectResponse
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

        return redirect()->route('dashboard.index')->with('success', 'Dokumen berhasil dihapus.');
    }
}
