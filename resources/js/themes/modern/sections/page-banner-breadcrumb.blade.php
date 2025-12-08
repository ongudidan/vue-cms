{{-- Page Banner with Breadcrumb Section --}}
<section class="py-12 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(!empty($section['data']['breadcrumb_items']) && is_array($section['data']['breadcrumb_items']))
        <div class="flex items-center space-x-2 text-sm text-gray-600 mb-4">
            @foreach($section['data']['breadcrumb_items'] as $index => $item)
            @if($index > 0)
            <span>/</span>
            @endif

            @if(!empty($item['url']) && $index < count($section['data']['breadcrumb_items']) - 1)
                <a href="{{ $item['url'] }}" class="hover:text-primary transition">
                {{ $item['label'] ?? '' }}
                </a>
                @else
                <span class="text-gray-900">{{ $item['label'] ?? '' }}</span>
                @endif
                @endforeach
        </div>
        @endif

        @if(!empty($section['data']['title']))
        <h1 class="text-3xl font-bold text-gray-900">
            {{ $section['data']['title'] }}
        </h1>
        @endif
    </div>
</section>