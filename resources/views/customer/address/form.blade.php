@extends('layouts.frontend')

@push('meta')
    @php
        $title = $title ?? 'Form Alamat';
        $description = $title ?? 'Form Alamat';
        $keywords = $title ?? 'Form Alamat';
    @endphp
    @include('frontend.partials.meta-home')
@endpush

@section('content')
    <section class="bg-gray-50 py-12">
        <div class="max-w-6xl mx-auto px-4">

            <form method="POST" action="{{ isset($address) ? route('customer.address.update', $address) : route('customer.address.store') }}">
                @csrf
                @isset($address)
                    @method('PATCH')
                @endisset

                <div class="bg-white rounded-2xl shadow-sm border">

                    {{-- HEADER --}}
                    <div class="px-8 py-6 border-b">
                        <h1 class="text-2xl font-semibold text-gray-800">
                            {{ $title }}
                        </h1>
                        <p class="text-sm text-justify text-gray-500 mt-1">
                            Gunakan alamat yang akurat untuk memastikan pengiriman berjalan lancar dan tepat waktu.
                            <br>
                            Pastikan titik pada peta sudah sesuai dengan lokasi pengiriman.
                        </p>
                    </div>

                    <div class="p-8 space-y-4">

                        {{-- BASIC INFO --}}
                        <div>
                            <h3 class="text-sm font-semibold text-gray-700 mb-4 uppercase tracking-wide">
                                Informasi Penerima
                            </h3>

                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="label">Label Alamat</label>
                                    <input name="label" value="{{ old('label', $address->label ?? '') }}" placeholder="Rumah / Kantor" class="input">
                                </div>

                                <div>
                                    <label class="label">Nama Penerima</label>
                                    <input name="receiver_name" value="{{ old('receiver_name', $address->receiver_name ?? '') }}" placeholder="Nama lengkap" class="input">
                                </div>
                            </div>

                            <div class="mt-4 max-w-md">
                                <label class="label">Nomor WhatsApp</label>
                                <input name="phone" value="{{ old('phone', $address->phone ?? '') }}" placeholder="628xxxxxxxxxx" class="input" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                            </div>
                        </div>

                        {{-- MAP --}}
                        <div>
                            <h3 class="text-sm font-semibold text-gray-700 mb-2 uppercase tracking-wide">
                                Lokasi Pengiriman
                            </h3>
                            <p class="text-xs text-red-500 italic" id="map-error" style="display:none;">
                                * Pilih titik lokasi pada peta
                            </p>

                            <div id="map" class="h-[420px] rounded-xl border"></div>

                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div>
                                    <label class="label">Latitude</label>
                                    <input id="latitude" name="latitude" value="{{ old('latitude', $address->latitude ?? '') }}" readonly class="input bg-gray-100">
                                </div>

                                <div>
                                    <label class="label">Longitude</label>
                                    <input id="longitude" name="longitude" value="{{ old('longitude', $address->longitude ?? '') }}" readonly class="input bg-gray-100">
                                </div>
                            </div>
                        </div>

                        {{-- REGION --}}
                        <div>
                            <h5 class="text-sm font-semibold text-gray-700 mb-2 uppercase tracking-wide">
                                Wilayah Administratif
                            </h5>

                            <div class="grid md:grid-cols-2 gap-4">
                                <select id="province" class="input">
                                    <option value="">Pilih Provinsi</option>
                                </select>

                                <select id="regency" class="input" disabled>
                                    <option value="">Pilih Kabupaten / Kota</option>
                                </select>

                                <select id="district" class="input" disabled>
                                    <option value="">Pilih Kecamatan</option>
                                </select>

                                <select id="sub_district" class="input" disabled>
                                    <option value="">Pilih Kelurahan / Desa</option>
                                </select>
                            </div>

                            <div class="mt-4 max-w-md">
                                <label class="label">Kode Pos</label>
                                <input name="postal_code" value="{{ old('postal_code', $address->postal_code ?? '') }}" class="input">
                            </div>
                        </div>

                        {{-- ADDRESS --}}
                        <div>
                            <label class="label">Alamat Lengkap</label>
                            <textarea name="address" rows="3" class="input" placeholder="Nama jalan, nomor rumah, patokan">{{ old('address', $address->address ?? '') }}</textarea>
                        </div>

                        {{-- DEFAULT --}}
                        <div class="mt-4 max-w-md flex items-center gap-2">
                            <input type="checkbox" name="is_default" id="is_default" class="h-4 w-4 rounded-sm border border-gray-300 accent-orange-500" {{ old('is_default', isset($address) ? $address->is_default : (Auth::user()->addresses->count() <= 1 ? true : false)) ? 'checked' : '' }}>
                            <label for="is_default" class="text-sm text-gray-700">
                                Jadikan alamat default
                            </label>
                        </div>

                        {{-- HIDDEN --}}
                        <input type="hidden" name="province_name" value="{{ $address->province ?? '' }}">
                        <input type="hidden" name="regency_name" value="{{ $address->regency ?? '' }}">
                        <input type="hidden" name="district_name" value="{{ $address->district ?? '' }}">
                        <input type="hidden" name="sub_district_name" value="{{ $address->sub_district ?? '' }}">

                        <input type="hidden" id="province_id" name="province_id" value="{{ $address->province_id ?? '' }}">
                        <input type="hidden" id="regency_id" name="regency_id" value="{{ $address->regency_id ?? '' }}">
                        <input type="hidden" id="district_id" name="district_id" value="{{ $address->district_id ?? '' }}">
                        <input type="hidden" id="sub_district_id" name="sub_district_id" value="{{ $address->sub_district_id ?? '' }}">

                        {{-- ACTION --}}
                        <div class="flex items-center justify-end gap-2 pt-6 border-t">
                            <a href="{{ route('customer.profile.index') }}"
                                class="px-4 py-2 rounded-lg text-sm font-semibold text-white bg-red-500 hover:bg-red-600">
                                Kembali
                            </a>
                            <button class="px-4 py-2 rounded-lg text-sm font-semibold text-white bg-orange-500 hover:bg-orange-600">
                                Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
    {{-- GOOGLE MAPS --}}
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}"></script>

    <script>
        let map, marker, geocoder;

        function initMap() {
            geocoder = new google.maps.Geocoder();

            const latInput = document.getElementById('latitude');
            const lngInput = document.getElementById('longitude');

            // parse lat lng dari input (jika ada)
            const lat = parseFloat(latInput.value);
            const lng = parseFloat(lngInput.value);

            const hasCoords = !isNaN(lat) && !isNaN(lng);

            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 15,
                center: hasCoords
                    ? { lat, lng }     // center ke koordinat yang ada
                    : { lat: -6.175392, lng: 106.827153 } // default Jakarta
            });

            marker = new google.maps.Marker({
                map,
                position: hasCoords
                    ? { lat, lng }     // set marker ke koordinat yang ada
                    : { lat: -6.175392, lng: 106.827153 },
                draggable: true
            });

            function update(pos) {
                latInput.value = pos.lat();
                lngInput.value = pos.lng();
            }

            // update koordinat saat marker di-drag
            marker.addListener('dragend', () => update(marker.getPosition()));

            // update koordinat saat map diklik
            map.addListener('click', e => {
                marker.setPosition(e.latLng);
                update(e.latLng);
            });
        }

        window.onload = initMap;
    </script>

    {{-- WILAYAH --}}
    <script>
        const API = 'https://www.emsifa.com/api-wilayah-indonesia/api';
        const province = document.getElementById('province');
        const regency = document.getElementById('regency');
        const district = document.getElementById('district');
        const village = document.getElementById('sub_district');

        const oldProvince = document.getElementById('province_id').value;
        const oldRegency = document.getElementById('regency_id').value;
        const oldDistrict = document.getElementById('district_id').value;
        const oldVillage = document.getElementById('sub_district_id').value;

        const reset = (el, text, disabled = true) => {
            el.innerHTML = `<option value="">${text}</option>`;
            el.disabled = disabled;
        };

        async function loadProvinces() {
            const res = await fetch(`${API}/provinces.json`);
            const data = await res.json();
            reset(province, 'Pilih Provinsi', false);
            data.forEach(i => {
                province.innerHTML += `<option value="${i.id}">${i.name}</option>`;
                console.log(i.id + ' - ' + i.name);
            });

            if (oldProvince) {
                province.value = oldProvince;
                await loadRegencies(oldProvince); // load kabupaten / kota
            }
        }

        async function loadRegencies(id) {
            reset(regency, 'Loading...');
            const res = await fetch(`${API}/regencies/${id}.json`);
            const data = await res.json();
            reset(regency, 'Pilih Kabupaten', false);
            data.forEach(i => {
                regency.innerHTML += `<option value="${i.id}">${i.name}</option>`;
                console.log(i.id + ' - ' + i.name);
            });

            if (oldRegency) {
                regency.value = oldRegency;
                await loadDistricts(oldRegency); // load kecamatan
            }
        }

        async function loadDistricts(id) {
            reset(district, 'Loading...');
            const res = await fetch(`${API}/districts/${id}.json`);
            const data = await res.json();
            reset(district, 'Pilih Kecamatan', false);
            data.forEach(i => {
                district.innerHTML += `<option value="${i.id}">${i.name}</option>`;
                console.log(i.id + ' - ' + i.name);
            });

            if (oldDistrict) {
                district.value = oldDistrict;
                await loadVillages(oldDistrict); // load kelurahan / desa
            }
        }

        async function loadVillages(id) {
            reset(village, 'Loading...');
            const res = await fetch(`${API}/villages/${id}.json`);
            const data = await res.json();
            reset(village, 'Pilih Desa', false);
            data.forEach(i => {
                village.innerHTML += `<option value="${i.id}">${i.name}</option>`;
                console.log(i.id + ' - ' + i.name);
            });

            if (oldVillage) {
                village.value = oldVillage;
            }
        }

        province.addEventListener('change', () => province.value && loadRegencies(province.value));
        regency.addEventListener('change', () => regency.value && loadDistricts(regency.value));
        district.addEventListener('change', () => district.value && loadVillages(district.value));

        (async () => {
            await loadProvinces();
        })();

        // update hidden names saat submit
        document.querySelector('form').addEventListener('submit', () => {
            document.querySelector('[name=province_name]').value = province.options[province.selectedIndex]?.text || '';
            document.querySelector('[name=regency_name]').value = regency.options[regency.selectedIndex]?.text || '';
            document.querySelector('[name=district_name]').value = district.options[district.selectedIndex]?.text || '';
            document.querySelector('[name=sub_district_name]').value = village.options[village.selectedIndex]?.text || '';
        });
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: @json(session('success')),
                confirmButtonColor: '#f97316'
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
