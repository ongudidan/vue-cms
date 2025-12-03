@php
   $backgroundImage = $section->media?->firstWhere('collection_name', 'section_bg');
@endphp
<section class="section services @if($section->section_has_bg) section-bg section-bg-fixed @endif" id="{{$section->spa_section_id ?? ''}}">
   @if($section->section_has_bg)
   <div class="{{ $section->section_background_color ?? 'bg-muted' }}">
      @if($section->section_background_type === 'image-bg')
      <img src="{{ $backgroundImage ? $backgroundImage->getUrl() : asset('website/images/backgrounds/T5.jpg') }}" alt="">
      @endif
   </div>
   @endif
   <div @class([
    $customisation->section_width_style ?? 'container',
    'w__' . ($customisation->section_width ?? '100'), 'mt-5' ])
   >
      @if($section->sub_title || $section->title || $section->details)
      <div class="row justify-content-center text-center">
         <div class="col-12 col-md-8 mx-auto">
            <div class="section-title mb-md-5 mb-3 text-center">
               @if($section->sub_title)
               <p class="sub-title" data-aos="zoom-in-up" data-aos-duration="1000" data-aos-delay="100">
                  {{ $section->sub_title }}
               </p>
               @endif
               @if($section->title)
               <h3 class="title" data-aos="zoom-in-up" data-aos-duration="1000" data-aos-delay="200">
                  {{ $section->title }}
               </h3>
               @endif
               @if($section->details)
               <div class="text-wrap details" data-aos="zoom-in-up" data-aos-duration="1000" data-aos-delay="300">
                  {!! $section->details !!}
               </div>
               @endif
               @if($section->has_cta_buttons && $section->cta_buttons->isNotEmpty())
               <div class="project-section-cta">
                  @foreach($section->cta_buttons as $button)
                     <a href="{{ url($button->page->slug ?? '#') }}" class="btn {{ $button->cta_button_type . ' ' . $customisation->button_style ?? '' }} me-2"
                           data-aos="zoom-in-up" data-aos-duration="1000" data-aos-delay="{{ ($key + 1) * 400 }}">
                        {{ $button->cta_button_text }}
                     </a>
                  @endforeach
               </div>
               @endif
            </div>
         </div>
      </div>
      @endif
      <div class="row">
      @if($section->type === 'section-with-services' && $section->section_style)
         @include('website.designs.' . $section->section_style, ['section' => $section, 'customisation' => $customisation])
      @else
         @foreach($services->take(3) as $key => $service)
         <div class="col-xl-4 col-lg-3 col-md-6 col-12" data-aos="zoom-in-up" data-aos-duration="1000" data-aos-delay="{{ ($key + 1) * 200 }}">
            <div class="mb-5">
               <div class="card service service-secondary shadow rounded overflow-hidden">
                  <div class="image position-relative overflow-hidden">
                     <img src="{{ $service->media[0]->original_url ?? asset('website/dummy_800x600.jpg') }}" class="img-fluid" alt="">
                  </div>
                  <div class="card-body content">
                     <a href="{{ route('services.show', $service->slug) }}" class="h5 title text-dark d-block mb-0">
{{--                        {!! Str::words($service->title, 2) !!}--}}
                        {{ $service->title }}
                     </a>
                     <div class="details mt-2 mb-2 fs-15">
                        {!! Str::words($service->details, 9) !!}
                     </div>
                     <a href="{{ route('services.show', $service->slug) }}" class="link text-dark">
                        Read More <i class="mdi mdi-arrow-right align-middle"></i>
                     </a>
                  </div>
               </div>
            </div>
         </div>
         @endforeach
      @endif
      </div>
   </div>
</section>
