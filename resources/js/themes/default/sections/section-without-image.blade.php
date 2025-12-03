@php
   $wordCount = str_word_count(strip_tags($section->details));
   $backgroundImage = $section->media?->firstWhere('collection_name', 'section_bg');
   $sectionImage = $section->media?->firstWhere('collection_name', 'section_image');
@endphp
@if($section->section_style)
   @include('website.designs.' . $section->section_style, ['section' => $section, 'wordCount' => $wordCount,
            'backgroundImage' => $backgroundImage, 'sectionImage' => $sectionImage, 'customisation' => $customisation])
@else
<section class="section @if($section->section_has_bg) section-bg section-bg-fixed @endif" id="{{$section->spa_section_id ?? ''}}">
   @if($section->section_has_bg)
   <div class="{{ $section->section_background_color ?? 'bg-overlay ' }}">
      @if($section->section_background_type === 'image-bg')
      <img src="{{ $backgroundImage->getUrl() ?? asset('website/images/backgrounds/T5.jpg') }}" alt="">
      @endif
   </div>
   @endif
   <div class="{{ $section->section_width_style ?? 'container' . ' w__' . $section->section_width ?? '100'}}">
      <div class="row justify-content-center text-center">
         <div class="col-12">
            <div class="mb-4">
               @if($section->sub_title)
               <p class="sub-title" data-aos="fade-up" data-aos-duration="1800" data-aos-delay="100">
                  {{ $section->sub_title }}
               </p>
               @endif
               @if($section->title)
               <h3 class="title" data-aos="fade-up" data-aos-duration="1800" data-aos-delay="200">
                  {{ $section->title }}
               </h3>
               @endif
               @if($section->details)
               <div class="details" data-aos="fade-up" data-aos-duration="1800" data-aos-delay="300">
                  {!! $section->details !!}
               </div>
               @endif
               @foreach($section->cta_buttons as $key => $button)
               <a href="{{ url($button->page->slug ?? '#') }}" class="btn {{ $button->cta_button_type . ' ' . $customisation->button_style ?? '' }}"
                     data-aos="fade-up" data-aos-duration="2000" data-aos-delay="{{ ($key + 1) * 400 }}">
                  {{ $button->cta_button_text }}
               </a>
               @endforeach
            </div>
         </div>
      </div>
   </div>
</section>
@endif
