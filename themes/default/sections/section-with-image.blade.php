@php
   $backgroundImage = $section->media?->firstWhere('collection_name', 'section_bg');
   $sectionImage = $section->media?->firstWhere('collection_name', 'section_image');
@endphp
<section class="section @if($section->section_has_bg) section-bg section-bg-fixed @endif" id="{{$section->spa_section_id ?? ''}}">
   @if($section->section_has_bg)
   <div class="{{ $section->section_background_color ?? '' }}">
      @if($section->section_background_type === 'image-bg')
      <img src="{{ $backgroundImage->getUrl() ?? asset('website/images/backgrounds/T5.jpg') }}" alt="image">
      @endif
   </div>
   @endif
   <div @class([
    $customisation->section_width_style ?? 'container',
    'w__' . ($customisation->section_width ?? '100') ])
   >
      <div class="row">
         @if($section->section_image_first)
         <div class="col-lg-5 align-self-center">
            <div class="mb-lg-0 mb-3" data-aos="fade-right" data-aos-duration="1800" data-aos-delay="200">
               <img src="{{ $sectionImage ? $sectionImage->getUrl() : asset('/website/dummy_1266x749.jpg') }}" alt="image"
                    class="img-fluid rounded-0">
            </div>
         </div>
         @endif
         <div class="col-lg-7 align-self-center">
            <div class="@if($section->section_image_first) ms-lg-5 @endif mb-lg-0 mb-3 section-title">
               @if($section->sub_title)
               <p class="sub-title" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                  {{ $section->sub_title }}
               </p>
               @endif
               <h2 class="title" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                  {{ $section->title }}
               </h2>
               <div class="details" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                  {!! $section->details !!}
               </div>
               @if($section->has_cta_buttons && $section->cta_buttons->isNotEmpty())
               @foreach($section->cta_buttons as $button)
               <a href="{{ url($button->page->slug ?? 'javascript:void(0)') }}" class="btn {{ $button->cta_button_type . ' ' . $customisation->button_style ?? '' }} me-2">
                  {{ $button->cta_button_text }}
               </a>
               @endforeach
               @endif
            </div>
         </div>
         @if(!$section->section_image_first)
         <div class="col-lg-5">
            <div class="ms-lg-5" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
               <div class="mb-3 mb-lg-0">
                  <img src="{{ $sectionImage ? $sectionImage->getUrl() : asset('/website/dummy_1266x749.jpg') }}" alt="image"
                       class="img-fluid rounded-0">
               </div>
            </div>
         </div>
         @endif
      </div>
   </div>
</section>
