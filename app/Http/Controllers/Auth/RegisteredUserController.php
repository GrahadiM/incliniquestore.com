<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // NORMALIZE WHATSAPP
        if ($request->filled('whatsapp')) {
            $wa = preg_replace('/\D/', '', $request->whatsapp);

            if (str_starts_with($wa, '08')) {
                $wa = '628' . substr($wa, 2);
            } elseif (str_starts_with($wa, '8')) {
                $wa = '628' . substr($wa, 1);
            }

            $request->merge(['whatsapp' => $wa]);
        }

        // Validation with custom message
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'whatsapp' => ['required', 'string', 'min:3', 'max:20', 'regex:/^[0-9]+$/'],
            'gender' => ['required', 'in:male,female'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            // Custom messages
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.string' => 'Nama lengkap harus berupa teks.',
            'name.max' => 'Nama lengkap maksimal :max karakter.',

            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'whatsapp.string' => 'Nomor WhatsApp harus berupa teks.',
            'whatsapp.min' => 'Nomor WhatsApp minimal :min karakter.',
            'whatsapp.max' => 'Nomor WhatsApp maksimal :max karakter.',
            'whatsapp.regex' => 'Nomor WhatsApp hanya boleh berisi angka 0-9.',

            'gender.required' => 'Silakan pilih jenis kelamin.',
            'gender.in' => 'Jenis kelamin harus Male atau Female.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal :max karakter.',
            'email.unique' => 'Email ini sudah terdaftar.',

            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal :min karakter.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'whatsapp' => $request->whatsapp,
            'gender' => $request->gender,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('customer');

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
