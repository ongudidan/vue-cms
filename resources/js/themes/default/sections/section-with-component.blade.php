@php
   $backgroundImage = $section->media?->firstWhere('collection_name', 'section_bg');
@endphp
<section class="section component @if($section->section_has_bg) section-bg section-bg-fixed @endif" id="{{$section->spa_section_id ?? ''}}">
   @if($section->section_has_bg)
   <div class="{{ $section->section_background_color ?? '' }}">
      @if($section->section_background_type === 'image-bg')
      <img src="{{ $backgroundImage->getUrl() ?? asset('website/images/backgrounds/T5.jpg') }}" alt="">
      @endif
   </div>
   @endif
      <div @class([
       $customisation->section_width_style ?? 'container',
       'w__' . ($customisation->section_width ?? '100') ])
      >
      @if($section->title)
      <div class="row justify-content-center">
         <div class="col-lg-7">
            <div class="text-center">
               @if($section->sub_title)
               <p class="sub_title" data-aos="fade-in-up" data-aos-duration="1000" data-aos-delay="100">
                  {{ $section->sub_title }}
               </p>
               @endif
               <h3 class="title" data-aos="fade-in-up" data-aos-duration="1000" data-aos-delay="200">
                  {{ $section->title }}
               </h3>
               <div class="details" data-aos="fade-in-up" data-aos-duration="1000" data-aos-delay="300">
                  {!! $section->details !!}
               </div>
            </div>
         </div>
      </div>
      @endif
      @includeIf('website.components.' . $section->component_type, ['section' => $section, 'customisation' => $customisation])
   </div>
</section>
