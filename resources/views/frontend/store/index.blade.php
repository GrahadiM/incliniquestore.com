
    <div class="w-full lg:max-w-7xl mx-auto px-4">

        <div class="mb-10">
            <h2 class="text-3xl font-bold text-gray-800">
                Lokasi Klinik Offline
            </h2>
            <p class="text-gray-500 mt-2">
                Temukan klinik terdekat dari lokasi Anda
            </p>
        </div>

        {{-- <!-- FILTER -->
        <div class="grid grid-cols-12 gap-4 mb-6">
            <div class="col-span-12 md:col-span-4">
                <select id="filter-province" class="w-full border rounded-lg px-4 py-2">
                    <option value="">Pilih Provinsi</option>
                </select>
            </div>

            <div class="col-span-12 md:col-span-4">
                <select id="filter-city" class="w-full border rounded-lg px-4 py-2" disabled>
                    <option value="">Pilih Kota</option>
                </select>
            </div>
        </div> --}}

        <!-- MAP + LIST -->
        <div class="grid grid-cols-12 gap-6">

            <!-- MAP -->
            <div class="col-span-12 lg:col-span-8">
                <div class="h-[480px] rounded-xl overflow-hidden border">
                    <iframe
                        id="store-map"
                        class="w-full h-full"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        src="https://maps.google.com/maps?q={{ $data['stores']->first()?->latitude }},{{ $data['stores']->first()?->longitude }}&hl=id&z=16&output=embed">
                    </iframe>
                </div>
            </div>

            <!-- STORE LIST -->
            <div class="col-span-12 lg:col-span-4">
                <div class="h-[480px] overflow-y-auto space-y-2 p-2" id="store-list">

                    @foreach ($data['stores'] as $store)
                        <div
                            class="store-item border rounded-xl p-4 cursor-pointer transition"
                            data-lat="{{ $store->latitude }}"
                            data-lng="{{ $store->longitude }}"
                            data-province="{{ $store->province }}"
                            data-city="{{ $store->city }}"
                        >
                            <div class="flex justify-between items-start">
                                <h3 class="font-semibold text-gray-800">
                                    {{ $store->name }}
                                </h3>

                                <span class="distance text-xs text-gray-500">
                                    -- km
                                </span>
                            </div>

                            <p class="text-sm text-gray-500 mt-1">
                                {{ $store->address }}
                            </p>

                            <div class="mt-2 text-sm text-gray-600 space-y-1">
                                @if($store->phone)
                                    <div><i class="fas fa-phone mr-2"></i>{{ $store->phone }}</div>
                                @endif
                                <div>
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    {{ $store->city }}, {{ $store->province }}
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

        </div>
    </div>

@push('scripts')
    <script>
        const mapFrame = document.getElementById('store-map');
        const storeList = document.getElementById('store-list');
        const storeItems = [...document.querySelectorAll('.store-item')];

        const provinceSelect = document.getElementById('filter-province');
        const citySelect = document.getElementById('filter-city');

        let userLat = null;
        let userLng = null;

        /* ================= MAP ================= */
        function updateMap(lat, lng) {
            mapFrame.src = `https://maps.google.com/maps?q=${lat},${lng}&hl=id&z=16&output=embed`;
        }

        function setActive(el) {
            storeItems.forEach(i =>
                i.classList.remove(
                    'ring-2',
                    'ring-primary-orange',
                    'bg-orange-50',
                    'border-primary-orange'
                )
            );

            el.classList.add(
                'ring-2',
                'ring-primary-orange',
                'bg-orange-50',
                'border-primary-orange'
            );

            // Auto scroll to active
            el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        /* ================= DISTANCE ================= */
        function distanceKm(lat1, lon1, lat2, lon2) {
            const R = 6371;
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;

            const a =
                Math.sin(dLat / 2) ** 2 +
                Math.cos(lat1 * Math.PI / 180) *
                Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLon / 2) ** 2;

            return R * (2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a)));
        }

        /* ================= CLICK STORE ================= */
        storeItems.forEach(item => {
            item.addEventListener('click', () => {
                updateMap(item.dataset.lat, item.dataset.lng);
                setActive(item);
            });
        });

        /* ================= GEOLOCATION ================= */
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(pos => {
                userLat = pos.coords.latitude;
                userLng = pos.coords.longitude;

                let nearest = null;
                let minDistance = Infinity;

                storeItems.forEach(item => {
                    const d = distanceKm(
                        userLat,
                        userLng,
                        parseFloat(item.dataset.lat),
                        parseFloat(item.dataset.lng)
                    );

                    item.dataset.distance = d;
                    item.querySelector('.distance').textContent = d.toFixed(1) + ' km';

                    if (d < minDistance) {
                        minDistance = d;
                        nearest = item;
                    }
                });

                // Sort by nearest
                storeItems
                    .sort((a, b) => a.dataset.distance - b.dataset.distance)
                    .forEach(el => storeList.appendChild(el));

                if (nearest) {
                    updateMap(nearest.dataset.lat, nearest.dataset.lng);
                    setActive(nearest);
                }
            });
        }

        /* ================= FILTER ================= */
        const provinces = [...new Set(storeItems.map(i => i.dataset.province).filter(Boolean))];
        provinces.forEach(p => {
            provinceSelect.innerHTML += `<option value="${p}">${p}</option>`;
        });

        provinceSelect.addEventListener('change', function () {
            const province = this.value;

            citySelect.innerHTML = '<option value="">Pilih Kota</option>';
            citySelect.disabled = !province;

            if (!province) {
                applyFilter();
                return;
            }

            const cities = [...new Set(
                storeItems
                    .filter(i => i.dataset.province === province)
                    .map(i => i.dataset.city)
            )];

            cities.forEach(c => {
                citySelect.innerHTML += `<option value="${c}">${c}</option>`;
            });

            applyFilter();
        });

        citySelect.addEventListener('change', applyFilter);

        function applyFilter() {
            const province = provinceSelect.value;
            const city = citySelect.value;

            storeItems.forEach(item => {
                let show = true;

                if (province && item.dataset.province !== province) show = false;
                if (city && item.dataset.city !== city) show = false;

                item.style.display = show ? '' : 'none';
            });
        }
    </script>
@endpush
