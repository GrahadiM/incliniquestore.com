@extends('layouts.frontend')

@push('meta')
    @php
        $title = 'Login';
        $description = 'Login';
        $keywords = 'Login';
    @endphp
    @include('frontend.partials.meta-home')
@endpush

@section('content')
    <section class="min-h-screen flex items-center justify-center bg-gray-50">
        <div class="w-full max-w-md bg-white rounded-xl shadow p-8">

            <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">
                Login Akun
            </h1>

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="text-sm text-gray-600">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-orange-200">
                </div>

                <div>
                    <label class="text-sm text-gray-600">Password</label>
                    <input type="password" name="password" required
                        class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-orange-200">
                </div>

                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="remember">
                        Ingat saya
                    </label>
                </div>

                <button type="submit"
                    class="w-full bg-primary-orange text-white py-2 rounded-lg font-semibold hover:bg-orange-600 transition">
                    Login
                </button>
            </form>

            <p class="text-sm text-center text-gray-500 mt-6">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-primary-orange font-medium">
                    Daftar sekarang
                </a>
            </p>

        </div>
    </section>
@endsection

@push('scripts')
    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                text: @json($errors->first()),
                confirmButtonColor: '#f97316'
            });
        </script>
    @endif

    @if (session('status'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: @json(session('status')),
                confirmButtonColor: '#22c55e'
            });
        </script>
    @endif

    @if (session('role_error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Login Ditolak',
                text: "{{ session('role_error') }}",
                confirmButtonColor: '#ef4444'
            });
        </script>
    @endif
@endpush
