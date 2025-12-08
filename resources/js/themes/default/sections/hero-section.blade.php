{{-- Hero Section - Simple and Clean --}}
<section class="hero-section relative overflow-hidden bg-gradient-to-br from-blue-600 to-purple-600 py-20">
   <div class="container mx-auto px-4">
      <div class="mx-auto max-w-4xl text-center text-white">
         @if(!empty($section['data']['subtitle']))
         <p class="mb-4 text-lg opacity-90" data-aos="fade-up">
            {{ $section['data']['subtitle'] }}
         </p>
         @endif

         @if(!empty($section['data']['title']))
         <h1 class="mb-6 text-5xl font-bold leading-tight md:text-6xl" data-aos="fade-up" data-aos-delay="200">
            {{ $section['data']['title'] }}
         </h1>
         @endif

         @if(!empty($section['data']['description']))
         <p class="mb-8 text-xl opacity-90" data-aos="fade-up" data-aos-delay="400">
            {{ $section['data']['description'] }}
         </p>
         @endif

         @if(!empty($section['data']['button_text']))
         <div class="flex flex-wrap justify-center gap-4" data-aos="fade-up" data-aos-delay="600">
            <a href="{{ $section['data']['button_url'] ?? '#' }}"
               class="inline-flex items-center rounded-lg bg-white px-8 py-3 font-semibold text-blue-600 shadow-lg transition hover:bg-gray-100">
               {{ $section['data']['button_text'] }}
            </a>
         </div>
         @endif
      </div>
   </div>
</section>