<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Logcontroller extends Controller
{
    public function index()
    {
        $logs = Log::with('user')->latest()->get();
        return view('history', compact('logs'));
    }
}
