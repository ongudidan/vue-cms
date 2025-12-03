{{-- CTA Section --}}
<section class="py-16 bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="md:flex items-center justify-between">
            <div class="md:w-2/3 mb-8 md:mb-0">
                @if(!empty($section['data']['title']))
                <h2 class="text-2xl md:text-3xl font-bold mb-4">
                    {{ $section['data']['title'] }}
                </h2>
                @endif

                @if(!empty($section['data']['subtitle']))
                <p class="text-gray-300">
                    {{ $section['data']['subtitle'] }}
                </p>
                @endif
            </div>

            @if(!empty($section['data']['button_text']))
            <div>
                <a href="{{ $section['data']['button_url'] ?? '#' }}"
                    class="inline-block px-8 py-3 bg-secondary text-white rounded-md font-medium hover:bg-opacity-90 transition">
                    {{ $section['data']['button_text'] }}
                </a>
            </div>
            @endif
        </div>
    </div>
</section>