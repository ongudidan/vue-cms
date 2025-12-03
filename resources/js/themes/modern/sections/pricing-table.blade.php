{{-- Pricing Table Section --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(!empty($section['data']['title']) || !empty($section['data']['subtitle']))
        <div class="text-center mb-12">
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

        @if(!empty($section['data']['plans']) && is_array($section['data']['plans']))
        <div class="grid md:grid-cols-{{ min(count($section['data']['plans']), 3) }} gap-8">
            @foreach($section['data']['plans'] as $plan)
            <div class="bg-white rounded-lg shadow-md overflow-hidden {{ !empty($plan['featured']) ? 'transform scale-105 border-2 border-primary' : '' }}">
                @if(!empty($plan['featured']))
                <div class="bg-primary p-2 text-center text-white text-sm font-medium">
                    Most Popular
                </div>
                @endif

                <div class="p-6 border-b border-gray-200">
                    @if(!empty($plan['name']))
                    <h3 class="text-xl font-semibold text-gray-900">{{ $plan['name'] }}</h3>
                    @endif

                    @if(!empty($plan['description']))
                    <p class="mt-2 text-gray-600">{{ $plan['description'] }}</p>
                    @endif
                </div>

                <div class="p-6">
                    @if(!empty($plan['price']))
                    <div class="flex items-baseline">
                        <span class="text-4xl font-bold text-gray-900">${{ $plan['price'] }}</span>
                        <span class="ml-1 text-gray-600">/{{ $plan['period'] ?? 'month' }}</span>
                    </div>
                    @endif

                    @if(!empty($plan['features']) && is_array($plan['features']))
                    <ul class="mt-6 space-y-3">
                        @foreach($plan['features'] as $feature)
                        <li class="flex items-center">
                            <i data-feather="check" class="text-green-500 w-5 h-5 mr-2"></i>
                            <span class="text-gray-600">{{ $feature }}</span>
                        </li>
                        @endforeach
                    </ul>
                    @endif

                    @if(!empty($plan['button_text']))
                    <button class="mt-8 w-full px-4 py-2 {{ !empty($plan['featured']) ? 'bg-primary text-white' : 'border border-primary text-primary' }} rounded-md hover:bg-primary hover:text-white transition">
                        {{ $plan['button_text'] }}
                    </button>
                    @endif
                </div>
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