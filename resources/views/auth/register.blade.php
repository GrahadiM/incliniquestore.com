@extends('layouts.frontend')

@push('meta')
    @php
        $title = 'Register';
        $description = 'Register';
        $keywords = 'Register';
    @endphp
    @include('frontend.partials.meta-home')
@endpush

@section('content')
    <section class="min-h-screen flex items-center justify-center bg-gray-50">
        <div class="w-full max-w-md bg-white rounded-xl shadow p-8">

            <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">
                Daftar Akun
            </h1>

            {{-- ERROR MESSAGE --}}
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 p-3 rounded mb-4 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                {{-- NAMA --}}
                <div>
                    <label class="text-sm text-gray-600 font-medium">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-orange-200">
                </div>

                {{-- WHATSAPP --}}
                <div>
                    <label class="text-sm text-gray-600 font-medium">
                        Nomor WhatsApp <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="08xxxxxxxxxx" required
                        inputmode="numeric" class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-orange-200">
                    <p class="text-xs text-gray-400 mt-1">
                        Hanya angka, tanpa spasi atau simbol.
                    </p>
                </div>

                {{-- GENDER --}}
                <div>
                    <label class="text-sm text-gray-600 font-medium block mb-1">
                        Jenis Kelamin <span class="text-red-500">*</span>
                    </label>

                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="gender" value="male"
                                {{ old('gender') === 'male' ? 'checked' : '' }}>
                            <span>Laki-laki</span>
                        </label>

                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="gender" value="female"
                                {{ old('gender') === 'female' ? 'checked' : '' }}>
                            <span>Perempuan</span>
                        </label>
                    </div>
                </div>

                {{-- EMAIL --}}
                <div>
                    <label class="text-sm text-gray-600 font-medium">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-orange-200">
                </div>

                {{-- PASSWORD --}}
                <div>
                    <label class="text-sm text-gray-600 font-medium">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password" required
                        class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-orange-200">
                </div>

                {{-- PASSWORD CONFIRM --}}
                <div>
                    <label class="text-sm text-gray-600 font-medium">
                        Konfirmasi Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password_confirmation" required
                        class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-orange-200">
                </div>

                {{-- SUBMIT --}}
                <button type="submit"
                    class="w-full bg-primary-orange text-white py-2 rounded-lg font-semibold hover:bg-orange-600 transition">
                    Daftar Sekarang
                </button>
            </form>

            <p class="text-sm text-center text-gray-500 mt-6">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-primary-orange font-medium">
                    Login
                </a>
            </p>

        </div>
    </section>
@endsection

@push('scripts')
    <script>
        const waInput = document.querySelector('input[name="whatsapp"]');

        if (waInput) {
            waInput.addEventListener('input', function() {
                let val = this.value.replace(/\D/g, ''); // hanya angka

                // Auto convert
                if (val.startsWith('08')) {
                    val = '628' + val.substring(2);
                } else if (val.startsWith('8')) {
                    val = '628' + val.substring(1);
                }

                this.value = val;
            });
        }
    </script>
@endpush
