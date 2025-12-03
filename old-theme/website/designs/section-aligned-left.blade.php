<div class="container-fluid px-0">
   <div class="py-5 position-relative"
        @if($section->section_background_type === 'image-bg')
           style="background: url({{ $backgroundImage ? $backgroundImage->getUrl() : asset('website/images/backgrounds/T5.jpg') }}) center;"
        @endif>
{{--      <div class="bg-overlay bg-gradient-overlay"></div>--}}
      <div @class([
       $customisation->section_width_style ?? 'container',
       'w__' . ($customisation->section_width ?? '100'), 'my-5' ])
      >
         <div class="row align-items-center">
            <div class="col-lg-8 col-md-7">
               <div class="section-title">
                  @if($section->sub_title)
                  <p class="sub-title mb-2" data-aos="fade-right" data-aos-duration="1800" data-aos-delay="100">
                     {{ $section->sub_title }}
                  </p>
                  @endif
                  <h4 class="title">{{ $section->title }}</h4>
                  <div class="text-muted para-desc details" data-aos="fade-right" data-aos-duration="1000" data-aos-delay="300">
                     {!! $section->details !!}
                  </div>
               </div>
            </div>

            <div class="col-lg-4 col-md-5 text-md-end mt-4 mt-sm-0">
               @foreach($section->cta_buttons as $key => $button)
                  <a href="{{ url($button->page?->slug ?? '#') }}" class="btn {{ $button->cta_button_type . ' ' . $customisation->button_style ?? '' }} me-2"
                     data-aos="fade-left" data-aos-duration="1800" data-aos-delay="{{ ($key + 1) * 300 }}">
                     {{ $button->cta_button_text }}
                  </a>
               @endforeach
            </div>
         </div>
      </div>
   </div>
</div>
