<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:20',
            'gender' => 'required|in:male,female',
        ]);

        Auth::user()->update($request->only([
            'name',
            'whatsapp',
            'gender',
        ]));

        return redirect()
            ->route('customer.profile.index')
            ->with('success', 'Profil berhasil diperbarui');
    }
}
