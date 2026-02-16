
<aside
    x-data="{
        isMobile: window.innerWidth < 768,
        open: false
    }"
    x-init="
        const isDashboard = {{ request()->routeIs('customer.*') ? 'true' : 'false' }};
        const savedState = localStorage.getItem('dashboard_menu');

        if (savedState !== null) {
            open = savedState === 'true';
        } else if (!isMobile) {
            open = true;
        } else {
            open = isDashboard;
        }

        $watch('open', value => {
            localStorage.setItem('dashboard_menu', value);
        });

        window.addEventListener('resize', () => {
            isMobile = window.innerWidth < 768;
            if (!isMobile) open = true;
        });
    "
    class="bg-white rounded-md shadow-sm border overflow-hidden"
>

    {{-- HEADER --}}
    <div class="flex items-center justify-between p-4 border-b">
        <span class="font-semibold text-gray-700">
            Menu Dashboard
        </span>

        {{-- TOGGLE (MOBILE ONLY) --}}
        <button
            x-show="isMobile"
            @click="open = !open"
            class="text-gray-500 hover:text-gray-700 transition"
            title="Toggle Menu"
        >
            {{-- UP = HIDE --}}
            <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 15l-7-7-7 7"/>
            </svg>

            {{-- DOWN = SHOW --}}
            <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 9l7 7 7-7"/>
            </svg>
        </button>
    </div>

    {{-- CONTENT --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="md:block"
    >
        <nav class="p-4 space-y-1 text-sm">

            @php
                $item = 'flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition';
            @endphp

            {{-- DASHBOARD --}}
            <a href="{{ route('customer.dashboard') }}"
               class="{{ $item }}
               {{ request()->routeIs('customer.dashboard')
                    ? 'bg-orange-50 text-primary-orange'
                    : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-home w-5"></i>
                Dashboard
            </a>

            {{-- ORDERS --}}
            <a href="{{ route('customer.orders.index') }}"
               class="{{ $item }}
               {{ request()->routeIs('customer.orders.*')
                    ? 'bg-orange-50 text-primary-orange'
                    : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-box w-5"></i>
                Riwayat Pesanan
            </a>

            {{-- PROFILE --}}
            <a href="{{ route('customer.profile.index') }}"
               class="{{ $item }}
               {{ request()->routeIs('customer.profile.*')
                    ? 'bg-orange-50 text-primary-orange'
                    : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-user w-5"></i>
                Profile
            </a>

            {{-- DIVIDER MENU --}}
            <div class="pt-4">
                <div class="border-t border-gray-200"></div>
            </div>

            {{-- LOGOUT SECTION --}}
            <div class="pt-2">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        class="w-full {{ $item }} text-red-500 hover:bg-red-50">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        Logout
                    </button>
                </form>
            </div>

        </nav>
    </div>
</aside>

@push('styles')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
