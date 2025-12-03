@php
   $backgroundImage = $section->media->firstWhere('collection_name', 'section_bg');
   $sectionImage = $section->media?->firstWhere('collection_name', 'section_image');
   $wordCount = str_word_count(strip_tags($section->details));
@endphp
<section class="section @if($section->section_background_type === 'image-bg') section-bg @endif"
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
      <div class="row">
         <div class="col-lg-6">
            @if($section->sub_title || $section->title || $section->details)
            <div class="mb-lg-0 mb-3 section-title">
               @if($section->sub_title)
               <p class="sub-title" data-aos="fade-up" data-aos-duration="1800" data-aos-delay="100">
                  {{ $section->sub_title }}
               </p>
               @endif
               @if($section->title)
               <h3 class="title mb-4" data-aos="fade-up" data-aos-duration="1800" data-aos-delay="200">
                  {{ $section->title }}
               </h3>
               @endif
               @if($section->details)
               <div class="details mb-4" data-aos="fade-up" data-aos-duration="1800" data-aos-delay="300">
                  {!! $section->details !!}
               </div>
               @endif
               @if($section->has_cta_buttons && $section->cta_buttons->isNotEmpty())
               @foreach($section->cta_buttons as $button)
               <a href="{{ url($button->page->slug ?? 'javascript:void(0)') }}" class="btn {{ $button->cta_button_type . ' ' . $customisation->button_style ?? '' }} me-2"
                     data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                  {{ $button->cta_button_text }}
               </a>
               @endforeach
               @endif
            </div>
            @endif
         </div>
         <div class="col-lg-6">
            <div class="ms-lg-5" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
               <div class="mb-3">
                  <div class="row">
                     @foreach($section->icon_boxes as $key => $card)
                     <div class="col-md-12" data-aos="zoom-in-up" data-aos-duration="1800" data-aos-delay="{{ ($key + 1) * 400 }}">
                        <div class="mb-3">
                           <div class="features feature-primary rounded px-4 py-3 bg-white shadow border-0 d-flex align-items-center">
                              <div class="fea-icon rounded text-white title-dark" style="height:50px; width:50px;">
                                 <i class="mdi {{ $card->icon ?? '' }} "></i>
                              </div>
                              <div class="content flex-1 ms-3">
                                 <h5 class="text-dark">{{ $card->title }}</h5>
                                 <div class="details mt-2 mb-0">
                                    {!! $card->details !!}
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     @endforeach
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
