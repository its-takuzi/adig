<?php

namespace App\Http\Controllers;

use App\Mail\UserCreated;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.user', compact('users'));
    }

    public function edit($id)
    {
        if (Auth::user()->role !== 'admin') { // ini jas
            abort(403, 'Akses ditolak'); // ini jas
        }
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') { // ini jas
            abort(403, 'Akses ditolak'); // ini jas
        }
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') { // ini jas
            abort(403, 'Akses ditolak'); // ini jas
        }
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
    }
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') { // ini jas
            abort(403, 'Akses ditolak'); // ini jas
        }

        $request->validate([
            'pp' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,staff',
        ]);

        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = $request->role;

            // Upload foto profil jika ada
            if ($request->hasFile('pp')) {
                $file = $request->file('pp');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('profile', $filename, 'public');
                $user->pp = $filename;
            }

            $user->save();

            // Kirim email setelah user berhasil disimpan
            Mail::to($user->email)->send(new UserCreated($user));

            return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan dan email sudah dikirim.');
        } catch (\Exception $e) { // ini jas
            return redirect()->route('users.index')->with('error', 'Gagal menyimpan user: ' . $e->getMessage()); // ini jas
        }
    }
}
