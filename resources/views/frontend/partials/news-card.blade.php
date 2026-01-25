
<div class="bg-white rounded-br-[24px] rounded-tl-[24px] hover:shadow-lg hover:shadow-orange-500/40 transition duration-300 overflow-hidden">
    <a href="{{ route('frontend.blog.detail', $news->slug) }}" class="block relative">
        <img
            src="{{ config('app.asset_url') . '/storage/' . $news->thumbnail }}"
            alt="{{ $news->meta_title ?? $news->title }}"
            class="w-full aspect-video object-cover">

        @if($news->is_featured)
            <span class="absolute top-3 left-3 bg-primary-red text-white text-xs font-semibold px-3 py-1 rounded-br-[8px] rounded-tl-[8px]">
                FEATURED
            </span>
        @endif
    </a>

    <div class="p-4">
        <h3 class="font-semibold text-base text-gray-800 mb-2 line-clamp-2">
            <a href="{{ route('frontend.blog.detail', $news->slug) }}">
                {{ $news->title }}
            </a>
        </h3>

        <p class="text-sm text-gray-600 mb-4 line-clamp-3">
            {{ $news->excerpt }}
        </p>

        <div class="flex items-center justify-between text-xs text-gray-500">
            <div class="flex items-center space-x-2">
                <i class="fas fa-user"></i>
                <span>{{ $news->author?->name ?? 'Admin' }}</span>
            </div>

            <div class="flex items-center space-x-2">
                <i class="fas fa-eye"></i>
                <span>{{ number_format($news->views) }}</span>
            </div>
        </div>
    </div>
</div>
