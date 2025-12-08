{{-- Team Grid Section --}}
<section class="py-20 bg-gray-50">
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

        @if(!empty($section['data']['members']) && is_array($section['data']['members']))
        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach($section['data']['members'] as $member)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                @if(!empty($member['image']))
                <img src="{{ $member['image'] }}" alt="{{ $member['name'] ?? 'Team member' }}"
                    class="w-full h-48 object-cover">
                @else
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                    <span class="text-4xl text-gray-400">{{ substr($member['name'] ?? 'U', 0, 1) }}</span>
                </div>
                @endif

                <div class="p-6">
                    @if(!empty($member['name']))
                    <h3 class="text-xl font-semibold text-gray-900">{{ $member['name'] }}</h3>
                    @endif

                    @if(!empty($member['position']))
                    <p class="text-gray-600">{{ $member['position'] }}</p>
                    @endif

                    <div class="flex mt-4 space-x-4">
                        @if(!empty($member['twitter']))
                        <a href="{{ $member['twitter'] }}" class="text-gray-400 hover:text-primary transition">
                            <i data-feather="twitter" class="w-5 h-5"></i>
                        </a>
                        @endif

                        @if(!empty($member['linkedin']))
                        <a href="{{ $member['linkedin'] }}" class="text-gray-400 hover:text-primary transition">
                            <i data-feather="linkedin" class="w-5 h-5"></i>
                        </a>
                        @endif

                        @if(!empty($member['email']))
                        <a href="mailto:{{ $member['email'] }}" class="text-gray-400 hover:text-primary transition">
                            <i data-feather="mail" class="w-5 h-5"></i>
                        </a>
                        @endif
                    </div>
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