@php
   $backgroundImage = $section->media->firstWhere('collection_name', 'section_bg');
   $sectionImage = $section->media?->firstWhere('collection_name', 'section_image');
   $wordCount = str_word_count(strip_tags($section->details));
@endphp
@if($section->section_style)
   @include('website.designs.' . $section->section_style, ['section' => $section, 'wordCount' => $wordCount,
            'backgroundImage' => $backgroundImage, 'sectionImage' => $sectionImage, 'customisation' => $customisation])
@else
<section class="section @if($section->section_background_type === 'image-bg') section-bg @endif" id="{{$section->spa_section_id ?? ''}}"
         @if($section->section_has_bg && $backgroundImage && !$section->section_background_color)
            style="background-image: url('{{ $backgroundImage->getUrl() }}'); background-size: cover; background-position: center;"
   @endif>
   @if($section->section_has_bg && $section->section_background_color)
      <div class="{{ $section->section_background_color }}">
         @if($section->section_background_type === 'image-bg')
         @if($backgroundImage)
         <img src="{{ $backgroundImage->getUrl() }}" alt="">
         @else
         <img src="{{ asset('website/dummy_1266x749.jpg') }}" alt="">
         @endif
         @endif
      </div>
   @endif
   <div @class([
    $customisation->section_width_style ?? 'container',
    'w__' . ($customisation->section_width ?? '100') ])
   >
      <div class="row justify-content-center">
         <div class="col-12 text-center">
            <div class="section-title mb-4 pb-2">
               @if($section->sub_title)
               <p class="sub-title" data-aos="fade-up" data-aos-duration="1800" data-aos-delay="100">
                  {{ $section->sub_title }}
               </p>
               @endif
               @if($section->title)
               <h2 class="title mb-4" data-aos="fade-up" data-aos-duration="1800" data-aos-delay="200">
                  {{ $section->title }}
               </h2>
               @endif
               @if($section->details)
               <div class="para-desc mb-0 mx-auto details" data-aos="fade-up" data-aos-duration="1800" data-aos-delay="300">
                  {!! $section->details !!}
               </div>
               @endif
            </div>
         </div>
      </div>

      <div class="row">
         <div class="col-12">
            <div class="section-testimonial-slider-{{$section->id}}">
               @foreach($section->section_testimonials as $key => $testimonial)
               <div class="tiny-slide mb-3" data-aos="zoom-in-up" data-aos-duration="1000" data-aos-delay="{{ ($key + 1) * 400 }}">
                  <div class="card border-0 text-center">
                     <div class="card-body">
                        <img src="{{ asset('dummy-image.jpg') }}" class="img-fluid avatar avatar-small rounded-circle mx-auto shadow" alt="">
                        <div class="text-muted mt-4 details">
                           {!! $testimonial->details !!}
                        </div>
                        <h6 class="text-primary">- {{ $testimonial->name }}</h6>
                     </div>
                  </div>
               </div>
               @endforeach
            </div>
         </div>
      </div>
   </div>
</section>
@endif

@push('scripts')
   <script>
      document.addEventListener("DOMContentLoaded", function () {

         const sliderClass = 'section-testimonial-slider-{{$section->id}}';
         const elements = document.getElementsByClassName(sliderClass);

         if (elements.length > 0) {
            tns({
               container: '.' + sliderClass,
               controls: false,
               mouseDrag: true,
               loop: true,
               rewind: false,
               autoplay: true,
               autoplayButtonOutput: false,
               autoplayHoverPause: true,
               autoplayTimeout: 3000,
               nav: true,
               navPosition: "bottom",
               speed: 400,
               gutter: 12,
               responsive: {
                  992: { items: 3 },
                  767: { items: 2 },
                  320: { items: 1 }
               }
            });
         }

      });
   </script>
@endpush

