@php
   $backgroundImage = $section->media->firstWhere('collection_name', 'section_bg');
   $wordCount = str_word_count(strip_tags($section->details));
@endphp
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
      <div class="row justify-content-center text-center">
         @if($section->sub_title || $section->title || $section->details)
         <div class="@if($wordCount > 20) col-lg-10 @else col-lg-6 @endif col-12">
            <div class="section-title mb-4">
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
            </div>
         </div>
         @endif
         <div class="col-12 mx-auto">
            <div class="row">
               @if($section->section_style)
                  @include('website.designs.' . $section->section_style, ['section' => $section, 'customisation' => $customisation])
               @else
               @foreach($section->section_cards as $key => $card)
               <div class="col-lg-4 col-md-6 col-12" data-aos="zoom-in-up" data-aos-duration="1800" data-aos-delay="{{ ($key + 1) * 400 }}">
                  <div class="mb-3">
                     <div class="card border-0 p-4 text-center rounded shadow features features-classic feature-primary">
                        <i class="mdi {{ $card->icon ?? '' }} icon h1"></i>
                        <div class="content">
                           <div class="title text-dark h5">{{ $card->title }}</div>
                           <div class="details mb-0 mt-3">{!! $card->details !!}</div>
                        </div>
                     </div>
                  </div>
               </div>
               @endforeach
               @endif
            </div>
         </div>
      </div>
   </div>
</section>
