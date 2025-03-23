<?php

namespace App\Http\Controllers;

use App\Models\Historylog;
use Illuminate\Http\Request;

class Historylogcontroller extends Controller
{
    public function index()
    {
        $logs = Historylog::with(['user', 'dokumen'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        return view('histori', compact('logs'));
    }
}
