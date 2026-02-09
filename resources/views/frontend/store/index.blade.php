
<section class="py-16 bg-white">
    <div class="w-full lg:max-w-7xl mx-auto px-4">

        <div class="mb-12">
            <h2 class="text-3xl font-bold text-gray-800">
                Lokasi Klinik Offline
            </h2>
            <p class="text-gray-500 mt-2">
                Kunjungi klinik resmi kami di lokasi terdekat
            </p>
        </div>

        <div class="grid grid-cols-12 gap-6">

            <!-- MAP -->
            <div class="col-span-12 lg:col-span-8">
                <div class="w-full h-[420px] rounded-xl overflow-hidden border">
                    <iframe
                        id="store-map"
                        src="https://maps.google.com/maps?q={{ $data['stores']->first()?->latitude }},{{ $data['stores']->first()?->longitude }}&hl=id&z=16&output=embed"
                        class="w-full h-full"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>

            <!-- STORE LIST -->
            <div class="col-span-12 lg:col-span-4 space-y-4" id="store-list">
                @forelse ($data['stores'] as $index => $store)
                    <div
                        class="store-item border rounded-xl p-4 cursor-pointer transition
                            hover:shadow-lg hover:shadow-orange-500/20"
                        data-index="{{ $index }}"
                        data-lat="{{ $store->latitude }}"
                        data-lng="{{ $store->longitude }}"
                    >
                        <h3 class="font-semibold text-gray-800">
                            {{ $store->name }}
                        </h3>

                        <p class="text-sm text-gray-500 mt-1">
                            {{ $store->address }}
                        </p>

                        <div class="mt-2 text-sm text-gray-600 space-y-1">
                            @if($store->phone)
                                <div><i class="fas fa-phone mr-2"></i>{{ $store->phone }}</div>
                            @endif
                            @if($store->city)
                                <div><i class="fas fa-map-marker-alt mr-2"></i>{{ $store->city }}, {{ $store->province }}</div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-gray-500">
                        Belum ada klinik offline tersedia.
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</section>

@push('scripts')
    <script>
        const mapFrame = document.getElementById('store-map');
        const storeItems = document.querySelectorAll('.store-item');

        function updateMap(lat, lng) {
            mapFrame.src = `https://maps.google.com/maps?q=${lat},${lng}&hl=id&z=15&output=embed`;
        }

        function setActiveStore(el) {
            storeItems.forEach(item => {
                item.classList.remove(
                    'ring-2',
                    'ring-primary-orange',
                    'bg-orange-50',
                    'border-primary-orange'
                );
            });

            el.classList.add(
                'ring-2',
                'ring-primary-orange',
                'bg-orange-50',
                'border-primary-orange'
            );
        }

        /**
         * Haversine Formula (km)
         */
        function getDistance(lat1, lon1, lat2, lon2) {
            const R = 6371;
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;

            const a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(lat1 * Math.PI / 180) *
                Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);

            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c;
        }

        /**
         * MANUAL CLICK
         */
        storeItems.forEach(item => {
            item.addEventListener('click', function () {
                const lat = parseFloat(this.dataset.lat);
                const lng = parseFloat(this.dataset.lng);

                updateMap(lat, lng);
                setActiveStore(this);
            });
        });

        /**
         * AUTO DETECT NEAREST STORE
         */
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(position => {
                const userLat = position.coords.latitude;
                const userLng = position.coords.longitude;

                let nearestStore = null;
                let shortestDistance = Infinity;

                storeItems.forEach(item => {
                    const storeLat = parseFloat(item.dataset.lat);
                    const storeLng = parseFloat(item.dataset.lng);

                    if (!storeLat || !storeLng) return;

                    const distance = getDistance(userLat, userLng, storeLat, storeLng);

                    if (distance < shortestDistance) {
                        shortestDistance = distance;
                        nearestStore = item;
                    }
                });

                if (nearestStore) {
                    updateMap(nearestStore.dataset.lat, nearestStore.dataset.lng);
                    setActiveStore(nearestStore);
                }
            }, () => {
                // Jika user deny location → fallback store pertama
                if (storeItems.length) {
                    setActiveStore(storeItems[0]);
                }
            });
        }
    </script>
@endpush

