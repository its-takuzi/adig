<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // ✅ Pastikan model User diimport
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    /**
     * Menampilkan halaman pengaturan pengguna.
     */
    public function edit()
    {
        return view('settings', ['user' => Auth::user()]);
    }

    /**
     * Memperbarui informasi profil pengguna (nama, email, password).
     */
    public function update(Request $request)
    {
        // ✅ Pastikan user ada di database
        $user = User::find(Auth::id());

        if (!$user) {
            return redirect()->route('settings.edit')->with('error', 'User tidak ditemukan.');
        }

        // ✅ Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
        ]);

        // ✅ Update data
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];

        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save(); // ✅ Pastikan objek ini berasal dari model User

        return redirect()->route('settings.edit')->with('success', 'Profil berhasil diperbarui!');
    }
    public function updateProfilePhoto(Request $request)
    {
        // ✅ Validasi input
        $request->validate([
            'pp' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::find(Auth::id());

        if (!$user) {
            return redirect()->route('settings.edit')->with('error', 'User tidak ditemukan.');
        }

        if ($request->hasFile('pp')) {
            $file = $request->file('pp');
            $filename = time() . '.' . $file->getClientOriginalExtension();

            if ($user->pp && $user->pp !== 'default.jpg') {
                Storage::delete('/storage/profile/' . $user->profipple_photo);
            }
            $file->storeAs('profile', $filename, 'public');

            $user->pp = $filename;
            $user->save();
        }

        return redirect()->route('settings.edit')->with('success', 'Foto profil berhasil diperbarui!');
    }
}
