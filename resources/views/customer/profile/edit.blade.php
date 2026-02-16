@extends('layouts.frontend')

@push('meta')
    @php
        $title = 'Edit Profile';
        $description = 'Edit informasi akun dan keamanan';
        $keywords = 'Edit Profile, Password';
    @endphp
    @include('frontend.partials.meta-home')
@endpush

@section('content')
    <section class="bg-gray-50 py-10">
        <div class="max-w-4xl mx-auto px-4 space-y-8">

            {{-- PROFILE DATA --}}
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-6">
                    Informasi Akun
                </h2>

                <form method="POST" action="{{ route('customer.profile.update') }}" class="space-y-5">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="text-sm font-medium text-gray-600">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full mt-1 rounded-lg border-gray-300 focus:ring-primary-orange focus:border-primary-orange">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Email</label>
                        <input type="email" value="{{ $user->email }}" disabled class="w-full mt-1 rounded-lg bg-gray-100 border-gray-300 cursor-not-allowed">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">No. WhatsApp</label>
                        <input type="text" name="whatsapp" value="{{ old('whatsapp', $user->whatsapp) }}" class="w-full mt-1 rounded-lg border-gray-300 focus:ring-primary-orange focus:border-primary-orange">
                    </div>

                    <div class="flex justify-end gap-2 pt-6 border-t">
                        <a href="{{ route('customer.profile.index') }}" class="px-4 py-2 rounded-lg text-sm font-semibold text-white bg-red-500 hover:bg-red-600">
                            Batal
                        </a>
                        <button class="px-4 py-2 rounded-lg text-sm font-semibold text-white bg-orange-500 hover:bg-orange-600">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>

            {{-- CHANGE PASSWORD --}}
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

                {{-- HEADER (TOGGLE) --}}
                <button type="button" onclick="togglePasswordSection()" class="w-full flex items-center justify-between p-6 text-left">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">
                            Ubah Password
                        </h2>
                        <p class="text-sm text-gray-500">
                            Demi keamanan akun, gunakan password yang kuat menggunakan kombinasi huruf, angka, dan simbol.
                        </p>
                    </div>
                    <i id="password-chevron" class="fas fa-chevron-down text-gray-400 transition-transform duration-300"></i>
                </button>

                {{-- CONTENT --}}
                <div id="password-section" class="px-6 pb-6 hidden">

                    <form method="POST" action="{{ route('customer.profile.update.password') }}" class="space-y-5">
                        @csrf
                        @method('PATCH')

                        {{-- PASSWORD LAMA --}}
                        <div>
                            <label class="text-sm font-medium text-gray-600">Password Lama</label>
                            <div class="relative mt-1">
                                <input type="password" name="current_password" id="current_password" class="w-full rounded-lg border-gray-300 pr-10 focus:ring-primary-orange focus:border-primary-orange">
                                <button type="button" onclick="togglePassword('current_password', this)" class="absolute inset-y-0 right-3 flex items-center text-gray-500">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        {{-- PASSWORD BARU --}}
                        <div>
                            <label class="text-sm font-medium text-gray-600">Password Baru</label>
                            <div class="relative mt-1">
                                <input type="password" name="password" id="password" oninput="checkPasswordStrength(this.value)" class="w-full rounded-lg border-gray-300 pr-10 focus:ring-primary-orange focus:border-primary-orange">
                                <button type="button" onclick="togglePassword('password', this)" class="absolute inset-y-0 right-3 flex items-center text-gray-500">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>

                            {{-- Strength Indicator --}}
                            <div class="mt-2">
                                <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div id="strength-bar" class="h-2 w-0 transition-all duration-300"></div>
                                </div>
                                <p id="strength-text"
                                class="text-xs mt-1 text-gray-500"></p>
                            </div>
                        </div>

                        {{-- KONFIRMASI --}}
                        <div>
                            <label class="text-sm font-medium text-gray-600">
                                Konfirmasi Password Baru
                            </label>
                            <div class="relative mt-1">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full rounded-lg border-gray-300 pr-10 focus:ring-primary-orange focus:border-primary-orange">
                                <button type="button" onclick="togglePassword('password_confirmation', this)" class="absolute inset-y-0 right-3 flex items-center text-gray-500">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="flex justify-end pt-6 border-t">
                            <button class="px-4 py-2 rounded-lg text-sm font-semibold text-white bg-red-500 hover:bg-red-600">
                                Ubah Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
@endsection

@push('scripts')
    <script>
        /* COLLAPSIBLE PASSWORD */
        function togglePasswordSection() {
            const section = document.getElementById('password-section');
            const icon = document.getElementById('password-chevron');

            section.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        }

        /* SHOW / HIDE PASSWORD */
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        /* PASSWORD STRENGTH */
        function checkPasswordStrength(password) {
            const bar = document.getElementById('strength-bar');
            const text = document.getElementById('strength-text');

            let score = 0;
            if (password.length >= 8) score++;
            if (/[A-Z]/.test(password)) score++;
            if (/[0-9]/.test(password)) score++;
            if (/[^A-Za-z0-9]/.test(password)) score++;

            const levels = [
                { w: '0%',   c: 'bg-gray-200',  t: '' },
                { w: '25%',  c: 'bg-red-500',   t: 'Password lemah' },
                { w: '50%',  c: 'bg-yellow-500',t: 'Password cukup' },
                { w: '75%',  c: 'bg-blue-500',  t: 'Password kuat' },
                { w: '100%', c: 'bg-green-500', t: 'Password sangat kuat' },
            ];

            const level = levels[score];
            bar.className = `h-2 transition-all duration-300 ${level.c}`;
            bar.style.width = level.w;
            text.textContent = level.t;
        }
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: @json(session('success')),
                timer: 2500,
                showConfirmButton: false
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                html: @json(implode('<br>', $errors->all())),
                confirmButtonColor: '#f97316'
            });
        </script>
    @endif
@endpush
