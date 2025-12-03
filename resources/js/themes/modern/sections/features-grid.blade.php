{{-- Features Grid Section --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(!empty($section['data']['title']) || !empty($section['data']['subtitle']))
        <div class="text-center mb-16">
            @if(!empty($section['data']['title']))
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                {{ $section['data']['title'] }}
            </h2>
            @endif

            @if(!empty($section['data']['subtitle']))
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                {{ $section['data']['subtitle'] }}
            </p>
            @endif
        </div>
        @endif

        @if(!empty($section['data']['features']) && is_array($section['data']['features']))
        <div class="grid md:grid-cols-3 gap-8">
            @foreach($section['data']['features'] as $index => $feature)
            <div class="bg-gray-50 p-8 rounded-lg hover:shadow-md transition"
                data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                @if(!empty($feature['icon']))
                <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mb-6">
                    <i data-feather="{{ $feature['icon'] }}" class="text-primary w-6 h-6"></i>
                </div>
                @endif

                @if(!empty($feature['title']))
                <h3 class="text-xl font-semibold mb-3">
                    {{ $feature['title'] }}
                </h3>
                @endif

                @if(!empty($feature['description']))
                <p class="text-gray-600">
                    {{ $feature['description'] }}
                </p>
                @endif
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>

<script>
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
</script>