{{-- Testimonials Section --}}
<section class="py-20 bg-gray-50">
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

        @if(!empty($section['data']['testimonials']) && is_array($section['data']['testimonials']))
        <div class="relative max-w-4xl mx-auto">
            @foreach($section['data']['testimonials'] as $index => $testimonial)
            <div class="bg-white p-8 rounded-lg shadow-md {{ $index > 0 ? 'hidden' : '' }}" data-testimonial="{{ $index }}">
                <div class="flex items-center mb-6">
                    @if(!empty($testimonial['image']))
                    <img src="{{ $testimonial['image'] }}" alt="{{ $testimonial['name'] ?? 'Client' }}"
                        class="w-16 h-16 rounded-full object-cover">
                    @else
                    <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center">
                        <span class="text-2xl text-gray-500">{{ substr($testimonial['name'] ?? 'U', 0, 1) }}</span>
                    </div>
                    @endif

                    <div class="ml-4">
                        @if(!empty($testimonial['name']))
                        <h4 class="font-semibold">{{ $testimonial['name'] }}</h4>
                        @endif

                        @if(!empty($testimonial['position']))
                        <p class="text-gray-600">{{ $testimonial['position'] }}</p>
                        @endif
                    </div>
                </div>

                @if(!empty($testimonial['quote']))
                <p class="text-gray-700 italic">"{{ $testimonial['quote'] }}"</p>
                @endif

                @if(count($section['data']['testimonials']) > 1)
                <div class="flex mt-6 space-x-2">
                    @foreach($section['data']['testimonials'] as $dotIndex => $dot)
                    <span class="w-3 h-3 rounded-full {{ $dotIndex === $index ? 'bg-primary' : 'bg-gray-300' }}"></span>
                    @endforeach
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>