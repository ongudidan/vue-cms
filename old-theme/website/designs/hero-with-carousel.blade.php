@push('styles')
   <link rel="stylesheet" href="{{ asset('website/css/swiper.min.css') }}">
   <style>
      .swiper-slider-hero {
         overflow: hidden;
      }

      .swiper-slide {
         height: 100vh;
      }

      .slide-bg-image {
         width: 100%;
         height: 100%;
         background-size: cover !important;
         background-position: center !important;
         background-repeat: no-repeat !important;
      }

      .bg-overlay {
         position: absolute;
         top: 0;
         left: 0;
         width: 100%;
         height: 100%;
         z-index: 1;
      }

      .slide-content-wrapper {
         position: relative;
         z-index: 2;
         width: 100%;
      }

      .swiper-button-next,
      .swiper-button-prev {
         width: 44px;
         height: 44px;
         background: rgba(255, 255, 255, 0.1);
         backdrop-filter: blur(10px);
         transition: all 0.3s ease;
      }

      .swiper-button-next:hover,
      .swiper-button-prev:hover {
         background: rgba(255, 255, 255, 0.2);
      }
   </style>
@endpush

@php
   // Get the hero image for the main section
   $heroImage = $section->media->where('collection_name', 'section_image')->first();
   $heroImageUrl = $heroImage ? $heroImage->original_url : asset('dummy-image.jpg');
@endphp

<section class="swiper-slider-hero position-relative d-block vh-100">
   <div class="swiper" id="heroSwiper-{{$section->id}}">
      <div class="swiper-wrapper">
         <div class="swiper-slide d-flex align-items-center overflow-hidden">
            <div class="slide-inner slide-bg-image d-flex align-items-center position-relative"
                 data-swiper-parallax="30%"
                 style="background: url('{{ $heroImageUrl }}');">
               <div class="bg-overlay bg-linear-gradient"></div>
               <div class="container slide-content-wrapper">
                  <div class="row justify-content-center">
                     <div class="col-12">
                        @if($section->title || $section->description || $section->sub_title)
                           <div class="title-heading text-center">
                              @if($section->sub_title)
                                 <h6 class="home-subtitle mb-4 text-wrap" data-swiper-parallax="-300">
                                    {{ $section->sub_title }}
                                 </h6>
                              @endif
                              <h1 class="fw-semibold display-3 text-white title-dark mb-4" data-swiper-parallax="-200">
                                 {{ $section->title }}
                              </h1>
                              <p class="para-desc mx-auto text-white-50 details" data-swiper-parallax="-100">
                                 {!! $section->description !!}
                              </p>

                              @if($section->has_cta_buttons && $section->cta_buttons->isNotEmpty())
                                 <div class="mt-4 pt-2" data-swiper-parallax="-50">
                                    @foreach($section->cta_buttons as $button)
                                       <a href="{{ url($button->page->slug ?? '#') }}"
                                          class="btn {{ $button->cta_button_type }} {{ $customisation->button_style ?? '' }} me-2">
                                          {{ $button->cta_button_text }}
                                       </a>
                                    @endforeach
                                 </div>
                              @endif
                           </div>
                        @endif
                     </div>
                  </div>
               </div>
            </div>
         </div>

         @foreach($section->hero_slides as $slide)
            @php
               $slideImage = $slide->media->where('collection_name', 'section_image')->first();
               $slideImageUrl = $slideImage ? $slideImage->original_url : asset('dummy-image.jpg');
            @endphp
            <div class="swiper-slide d-flex align-items-center overflow-hidden">
               <div class="slide-inner slide-bg-image d-flex align-items-center position-relative"
                    data-swiper-parallax="30%"
                    style="background: url('{{ $slideImageUrl }}');">
                  <div class="bg-overlay bg-linear-gradient"></div>
                  <div class="container slide-content-wrapper">
                     <div class="row justify-content-center">
                        <div class="col-12">
                           @if($slide->title || $slide->details || $slide->sub_title || $slide->page)
                              <div class="title-heading text-center">
                                 @if($slide->sub_title)
                                    <h6 class="home-subtitle mb-4 text-wrap" data-swiper-parallax="-300">
                                       {{ $slide->sub_title }}
                                    </h6>
                                 @endif
                                 <h1 class="fw-semibold display-3 text-white title-dark mb-4" data-swiper-parallax="-200">
                                    {{ $slide->title }}
                                 </h1>
                                 <p class="para-desc mx-auto text-white-50 details" data-swiper-parallax="-100">
                                    {!! $slide->details !!}
                                 </p>
                                 @if($slide->page)
                                    <div class="mt-4 pt-2" data-swiper-parallax="-50">
                                       <a href="{{ url($slide->page->slug ?? '#') }}"
                                          class="btn {{ $slide->cta_button_type }} {{ $customisation->button_style ?? '' }}">
                                          {{ $slide->cta_button_text }}
                                       </a>
                                    </div>
                                 @endif
                              </div>
                           @endif
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         @endforeach
      </div>

      <div class="booking-form-overlay position-absolute w-100">
         @include('website.domain-search')
      </div>

      <div class="swiper-button-next border rounded-circle text-center"></div>
      <div class="swiper-button-prev border rounded-circle text-center"></div>
      <div class="swiper-pagination"></div>
   </div>
</section>

@push('scripts')
   <script src="{{ asset('website/js/swiper-bundle.min.js') }}"></script>
   <script>
      document.addEventListener('DOMContentLoaded', function() {
         // Debug: Check if images are loading
         const slides = document.querySelectorAll('#heroSwiper-{{ $section->id }} .slide-bg-image');
         console.log('Total slides:', slides.length);
         slides.forEach((slide, index) => {
            const bgImage = slide.style.backgroundImage;
            console.log(`Slide ${index} background:`, bgImage);

            // Extract and test URL
            const urlMatch = bgImage.match(/url\(['"]?([^'"]+)['"]?\)/);
            if(urlMatch && urlMatch[1] && urlMatch[1] !== 'null') {
               console.log(`Slide ${index} URL:`, urlMatch[1]);
               // Test if image loads
               const testImg = new Image();
               testImg.onload = () => console.log(`✓ Slide ${index} image loaded successfully`);
               testImg.onerror = () => console.error(`✗ Slide ${index} image failed to load:`, urlMatch[1]);
               testImg.src = urlMatch[1];
            } else {
               console.error(`✗ Slide ${index} has no valid URL`);
            }
         });

         const heroSwiper = new Swiper('#heroSwiper-{{ $section->id }}', {
            loop: true,
            speed: 1200,
            grabCursor: true,

            autoplay: {
               delay: 5000,
               disableOnInteraction: false,
               pauseOnMouseEnter: true,
            },

            parallax: true,
            effect: 'slide',

            navigation: {
               nextEl: '.swiper-button-next',
               prevEl: '.swiper-button-prev',
            },

            pagination: {
               el: '.swiper-pagination',
               clickable: true,
               dynamicBullets: true,
            },

            keyboard: {
               enabled: true,
               onlyInViewport: true,
            },

            touchRatio: 1,
            touchAngle: 45,
            preventClicksPropagation: true,
            preventClicks: true,

            on: {
               init: function() {
                  console.log('✓ Swiper initialized successfully');
                  console.log('Active slide:', this.activeIndex);
               },
               slideChange: function() {
                  console.log('Slide changed to:', this.activeIndex);
               }
            }
         });

         const swiperEl = document.querySelector('#heroSwiper-{{ $section->id }}');

         swiperEl.addEventListener('mouseenter', function() {
            heroSwiper.autoplay.stop();
         });

         swiperEl.addEventListener('mouseleave', function() {
            heroSwiper.autoplay.start();
         });
      });
   </script>
@endpush
