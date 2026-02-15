@props(['title', 'value', 'icon'])

<div class="bg-white p-4 rounded-md shadow flex items-center gap-4">
    <div class="text-primary-orange text-2xl">
        <i class="fas fa-{{ $icon }}"></i>
    </div>
    <div>
        <p class="text-gray-500 text-sm">{{ $title }}</p>
        <p class="text-gray-800 font-semibold text-lg">{{ $value }}</p>
    </div>
</div>
