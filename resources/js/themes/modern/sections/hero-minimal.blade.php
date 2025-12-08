{{-- Hero Minimal Section --}}
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            @if(!empty($section['data']['title']))
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                {{ $section['data']['title'] }}
            </h1>
            @endif

            @if(!empty($section['data']['subtitle']))
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                {{ $section['data']['subtitle'] }}
            </p>
            @endif

            @if(!empty($section['data']['button_text']))
            <div class="mt-8">
                <a href="{{ $section['data']['button_url'] ?? '#' }}"
                    class="inline-block px-8 py-3 bg-primary text-white rounded-md font-medium hover:bg-opacity-90 transition">
                    {{ $section['data']['button_text'] }}
                </a>
            </div>
            @endif
        </div>
    </div>
</section>