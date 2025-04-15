<?php

use App\Http\Controllers\ChartDokumenController;
use App\Http\Controllers\Dashboardcontroller;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\Historylogcontroller;
use App\Http\Controllers\rakcontroller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('login');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ]);
})->name('login.process');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/users/{id}/update', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');

    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::post('/settings/update-photo', [SettingsController::class, 'updateProfilePhoto'])->name('settings.updatePhoto');

    //arsip
    Route::get('/arsip', [DokumenController::class, 'index'])->name('arsip.index');
    Route::delete('/dokumen/{id}', [DokumenController::class, 'destroy'])->name('dokumen.destroy');
    Route::get('/arsip/dokumen/{id}', [DokumenController::class, 'download'])->name('dokumen.download');
    Route::post('/arsip/store', [DokumenController::class, 'store'])->name('dokumen.store');
    Route::get('/arsip/{id}/detail', [DokumenController::class, 'detail']);
    Route::get('/arsip/{id}/edit', [DokumenController::class, 'edit'])->name('dokumen.edit');
    Route::put('/arsip/{id}', [DokumenController::class, 'update'])->name('dokumen.update');




    //history
    Route::get('/histori', [Historylogcontroller::class, 'index'])->name('histori.index');

    //dashboard
    Route::get('/dashboard', [Dashboardcontroller::class, 'index'])->name('dashboard.index');

    //chart
    Route::get('/chart', [ChartDokumenController::class, 'index']);

    //rak
    Route::get('/rak', [rakcontroller::class, 'index'])->name('rak.index');
    Route::post('/rak', [RakController::class, 'store'])->name('rak.store');

    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');
});

// //arsip
// Route::get('/arsip', [DokumenController::class, 'index'])->name('arsip.index');
// Route::delete('/dokumen/{id}', [DokumenController::class, 'destroy'])->name('dokumen.destroy');
// Route::get('/arsip/dokumen/{id}', [DokumenController::class, 'download'])->name('dokumen.download');
// Route::post('/arsip/store', [DokumenController::class, 'store'])->name('dokumen.store');


// //history
// Route::get('/histori', [Historylogcontroller::class, 'index'])->name('histori.index');

// //dashboard
// Route::get('/dashboard', [Dashboardcontroller::class, 'index'])->name('dashboard.index');
