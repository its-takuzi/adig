<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Rak;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;

class rakcontroller extends Controller
{
    public function index(Request $request)
    {

        $query = Dokumen::with('rak');
        if ($request->filled('nama_rak')) {
            $query->whereHas('rak', function ($q) use ($request) {
                $q->where('nama_rak', $request->nama_rak);
            });
        }

        $dokumens = $query->latest()->paginate(10);
        $listRak = Rak::orderBy('nama_rak')->pluck('nama_rak');

        return view('rak', compact('dokumens', 'listRak'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_rak' => 'required|string|max:255|unique:rak,nama_rak',
        ]);

        Rak::create([
            'nama_rak' => $request->nama_rak,
        ]);

        return redirect()->route('rak.index')->with('success', 'Rak berhasil ditambahkan.');
    }
}
