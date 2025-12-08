<section class="section @if($section->section_has_bg) section-bg section-bg-fixed @endif" id="{{$section->spa_section_id ?? ''}}">
   @if($section->section_has_bg)
   <div class="{{ $section->section_background_color ?? '' }}">
      @if($section->section_background_type === 'image-bg')
      @php
         $backgroundImage = $section->media
             ->firstWhere('collection_name', 'section_bg');
      @endphp
      <img src="{{ $backgroundImage->getUrl() ?? asset('website/images/backgrounds/T5.jpg') }}" alt="">
      @endif
   </div>
   @endif
      <div @class([
       $customisation->section_width_style ?? 'container',
       'w__' . ($customisation->section_width ?? '100') ])
      >
      <div class="row justify-content-center text-center">
         <div class="col-lg-10 col-12 mb-3" data-aos="zoom-in-up" data-aos-duration="1000" data-aos-delay="100">
            <div class="mb-4">
               @if($section->sub_title)
               <p class="sub-title">
                  {{ $section->sub_title }}
               </p>
               @endif
               <h3 class="title">{{ $section->title }}</h3>
               <div class="details">
                  {!! $section->details !!}
               </div>
               @foreach($section->cta_buttons as $button)
                  <a href="{{ url($button->page->slug ?? '#') }}" class="btn {{ $button->cta_button_type . ' ' . $customisation->button_style ?? '' }}">
                     {{ $button->cta_button_text }}
                  </a>
               @endforeach
            </div>
         </div>
      </div>
      <div class="row align-items-center">
         @foreach($skills->take(4) as $key => $skill)
         <div class="col-lg-6 col-12">
            <div data-aos="fade-up" data-aos-duration="800" data-aos-delay="{{ $key * 200 }}">
               <div class="card skill-card ">
                  <div class="card-body">
                     <h5 class="skill-heading {{ $key === 1 || $key === 3 ? 'text-primary' : 'text-secondary' }}">{{ $skill->title }}</h5>
                     <div class="skill-details">{!! $skill->details !!}</div>
                  </div>
               </div>
            </div>
         </div>
         @endforeach
         {{--         <div class="col-lg-4">--}}
{{--            <div data-aos="fade-left" data-aos-duration="1800">--}}
{{--               <div class="mb-4 mb-lg-0 justify-content-center align-content-center">--}}
{{--                  <img src="{{ $section->media[0]->original_url ?? asset('/website/dummy_800x600.jpg') }}" alt=""--}}
{{--                       class="img-fluid rounded-3 h-100 w-100 object-cover">--}}
{{--               </div>--}}
{{--            </div>--}}
{{--         </div>--}}
      </div>
   </div>
</section>
