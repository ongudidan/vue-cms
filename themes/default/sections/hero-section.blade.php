@if($section->section_style)
@include('website.designs.' . $section->section_style, ['section' => $section, 'customisation' => $customisation])
@else
<section class="bg-half-170 bg-light pb-0 d-table w-100" style="max-height: 1200px; min-height: 750px; background-image:url({{ $section->media[0]->original_url ?? asset('dummy-image.jpg') }});" id="{{$section->spa_section_id ?? ''}}">
   <div class="bg-overlay bg-gradient-overlay"></div>
   <div @class([
      $customisation->section_width_style ?? 'container',
      'w__' . ($customisation->section_width ?? '100') ])
      >
      <div class="row mt-5 text-center">
         <div class="col-lg-10 col-md-6 mx-auto">
            <div class="title-heading">
               @if($section->sub_title)
               <h6 class="home-subtitle mb-4 text-wrap text-primary" data-aos="fade-right" data-aos-duration="1000" data-aos-delay="600">
                  {{ $section->sub_title }}
               </h6>
               @endif
               @if($section->title)
               <h3 class="display-6 mb-4 fw-bold text-white" data-aos="fade-right" data-aos-duration="1200" data-aos-delay="800">
                  {{ $section->title }}
               </h3>
               @endif
               @if($section->details)
               <div class="text-muted details w-100" data-aos-duration="1400" data-aos-delay="1000">
                  {!! $section->details !!}
               </div>
               @endif
               @if($section->has_cta_buttons && $section->cta_buttons->isNotEmpty())
               <div class="mt-4 pt-2">
                  @foreach($section->cta_buttons as $button)
                  <a href="{{ url($button->page->slug ?? 'javascript:void(0)') }}" class="btn {{ $button->cta_button_type . ' ' . $customisation->button_style ?? '' }}">
                     {{ $button->cta_button_text }}
                  </a>
                  @endforeach
               </div>
               @endif
            </div>
         </div>
      </div>

      @if($page->type->name === 'CMS')
      @include('website.domain-search')
      @endif
   </div>
</section>
@endif