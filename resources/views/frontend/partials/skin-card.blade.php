
<div class="bg-primary-light p-6 text-justify border border-orange-300 rounded-tl-[24px] rounded-br-[24px] hover:shadow-lg hover:shadow-orange-500/50 transition duration-300">
    <div class="{{ $item['icon_bg'] }} w-16 h-16 border border-orange-300 rounded-tl-[12px] rounded-br-[12px] flex items-center justify-center mb-4">
        <i class="{{ $item['icon'] }} {{ $item['icon_color'] }} text-2xl"></i>
    </div>

    <h3 class="text-xl font-semibold text-gray-800 mb-2">
        {{ $item['title'] }}
    </h3>

    <p class="text-base lg:text-lg text-gray-800 mb-4">
        {{ $item['desc'] }}
    </p>

    {{-- <a href="{{ route('frontend.index') }}" class="absolute -top-4 -right-2 rounded-br-[16px] rounded-tl-[16px] inline-block bg-primary-orange text-white text-sm font-medium px-4 py-2 hover:shadow-lg hover:shadow-orange-500/50 transition duration-300">
        Lihat Produk
    </a> --}}
</div>
