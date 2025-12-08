{{-- Page Banner Section --}}
<section class="py-16 bg-primary text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        @if(!empty($section['data']['title']))
        <h1 class="text-3xl md:text-4xl font-bold mb-2">
            {{ $section['data']['title'] }}
        </h1>
        @endif

        @if(!empty($section['data']['subtitle']))
        <p class="text-lg opacity-90">
            {{ $section['data']['subtitle'] }}
        </p>
        @endif
    </div>
</section>