@extends('layouts.frontend')

@push('meta')
    @php
        $title = 'Edit Profile';
        $description = 'Edit informasi akun';
        $keywords = 'Edit Profile, Akun';
    @endphp
    @include('frontend.partials.meta-home')
@endpush

@section('content')
    <section class="bg-gray-50 py-10">
        <div class="max-w-3xl mx-auto px-4">

            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h1 class="text-xl font-semibold text-gray-800 mb-6">
                    Edit Profile
                </h1>

                <form method="POST" action="{{ route('customer.profile.update') }}" class="space-y-5">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="text-sm text-gray-600">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full mt-1 rounded-lg border-gray-300 focus:ring-primary-orange focus:border-primary-orange">
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Email</label>
                        <input type="email" value="{{ $user->email }}" disabled class="w-full mt-1 rounded-lg bg-gray-100 border-gray-300">
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">No. WhatsApp</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full mt-1 rounded-lg border-gray-300">
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('customer.profile.index') }}" class="px-4 py-2 text-sm border rounded-lg">
                            Batal
                        </a>
                        <button class="px-5 py-2 text-sm bg-primary-orange text-white rounded-lg">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </section>
@endsection

@push('scripts')
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: '{{ session('success') }}',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false,
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                html: @json(implode('<br>', $errors->all())),
                confirmButtonColor: '#f97316'
            });
        </script>
    @endif
@endpush
