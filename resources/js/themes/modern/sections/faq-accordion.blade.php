{{-- FAQ Accordion Section --}}
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

        @if(!empty($section['data']['faqs']) && is_array($section['data']['faqs']))
        <div class="max-w-3xl mx-auto">
            @foreach($section['data']['faqs'] as $index => $faq)
            <div class="mb-4 border border-gray-200 rounded-lg overflow-hidden">
                <button onclick="toggleFaq({{ $index }})"
                    class="w-full flex justify-between items-center p-4 text-left bg-gray-50 hover:bg-gray-100 transition">
                    @if(!empty($faq['question']))
                    <span class="font-medium text-gray-900">{{ $faq['question'] }}</span>
                    @endif
                    <i data-feather="chevron-down"
                        class="faq-icon-{{ $index }} w-5 h-5 text-gray-500 transform transition-transform duration-200"></i>
                </button>

                <div id="faq-{{ $index }}" class="faq-content hidden p-4 bg-white">
                    @if(!empty($faq['answer']))
                    <p class="text-gray-600">{{ $faq['answer'] }}</p>
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

    function toggleFaq(index) {
        const content = document.getElementById('faq-' + index);
        const icon = document.querySelector('.faq-icon-' + index);

        if (content.classList.contains('hidden')) {
            content.classList.remove('hidden');
            icon.classList.add('rotate-180');
        } else {
            content.classList.add('hidden');
            icon.classList.remove('rotate-180');
        }
    }
</script>