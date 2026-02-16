<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    public function index()
    {
        $addresses = Auth::user()->addresses;

        return view('customer.profile.index', [
            'user' => Auth::user(),
            'addresses' => $addresses,
        ]);
    }

    public function edit()
    {
        return view('customer.profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'whatsapp' => 'required|string|max:20',
        ], [
            'name.required'  => 'Nama lengkap wajib diisi.',
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
        ]);

        Auth::user()->update($data);

        return redirect()->route('customer.profile.index')->with('success', 'Profil berhasil diperbarui');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Password lama tidak sesuai.',
            ]);
        }

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('customer.profile.edit')->with('success', 'Password berhasil diubah');
    }
}
