@php
   $wordCount = str_word_count(strip_tags($section->details));
   $backgroundImage = $section->media?->firstWhere('collection_name', 'section_bg');
   $sectionImage = $section->media?->firstWhere('collection_name', 'section_image');
@endphp
<section class="section projects @if($section->section_has_bg) section-bg section-bg-fixed @endif" id="{{$section->spa_section_id ?? ''}}">
   @if($section->section_has_bg)
      <div class="{{ $section->section_background_color ?? 'bg-overlay ' }}">
         @if($section->section_background_type === 'image-bg')
            <img src="{{ $backgroundImage->getUrl() ?? asset('website/images/backgrounds/T5.jpg') }}" alt="">
         @endif
      </div>
   @endif
      <div @class([
       $customisation->section_width_style ?? 'container',
       'w__' . ($customisation->section_width ?? '100') ])
      >
      <div class="row">
         <div class="col-12 col-xl-12 col-md-12" data-aos="zoom-in-up" data-aos-duration="1000" data-aos-delay="100">
            <div class="section-title mb-md-5 mb-3 text-center">
               @if($section->sub_title)
               <p class="sub-title" data-aos="fade-up" data-aos-duration="1800" data-aos-delay="100">
                  {{ $section->sub_title }}
               </p>
               @endif
               <h2 class="title" data-aos="fade-up" data-aos-duration="1800" data-aos-delay="200">
                  {{ $section->title ?? '' }}
               </h2>
               <div class="details" data-aos="fade-up" data-aos-duration="1800" data-aos-delay="300">
                  {!! $section->details ?? '' !!}
               </div>
               @if($section->has_cta_buttons && $section->cta_buttons->isNotEmpty())
               <div class="project-section-cta">
                  @foreach($section->cta_buttons as $key => $button)
                  <a href="{{ url($button->page->slug ?? '#') }}" class="btn {{ $button->cta_button_type . ' ' . $customisation->button_style ?? '' }} me-2"
                        data-aos="fade-up" data-aos-duration="1800" data-aos-delay="{{ ($key + 1) * 300 }}">
                     {{ $button->cta_button_text }}
                  </a>
                  @endforeach
               </div>
               @endif
            </div>
         </div>
      </div>
      <div class="row">
      @if($section->section_style)
         @include('website.designs.' . $section->section_style, ['section' => $section, 'customisation' => $customisation])
      @else
         @foreach($projects->take(3) as $key => $project)
         <div class="col-lg-4 col-md-6 col-12" data-aos="zoom-in-up" data-aos-duration="1000" data-aos-delay="{{ $key * 200 }}">
            <div class="mb-5">
               <div class="card  shadow rounded overflow-hidden">
                  <div class="image position-relative overflow-hidden">
                     <img src="{{ $project->media[0]->original_url ?? asset('website/dummy_800x600.jpg') }}" alt="{{$project->slug}}"
                          class="img-fluid w-100" style="height:270px;">
                  </div>
                  <div class="card-body content">
                     <a href="{{ route('projects.show', $project->slug) }}" class="h5 title text-dark d-block mb-0">
                        {{ $project->title }}
                     </a>
                     <div class="mt-2 mb-2 fs-15 details">
                        {!! Str::words($project->details, 9) !!}
                     </div>
                     <a href="{{ route('projects.show', $project->slug) }}" class="link text-dark">
                        Read More <i class="mdi mdi-arrow-right align-middle"></i>
                     </a>
                  </div>
               </div>
            </div>
         </div>
{{--         <div class="col-12 col-xl-4 col-lg-4 col-md-6">--}}
{{--            <div class="mb-5">--}}
{{--               <div class="card h-100" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="{{ $key * 100 }}">--}}
{{--                  <img src="{{ $project->media[0]->original_url ?? asset('website/images/dummy-image.jpg') }}" alt="" class="card-img-top fixed">--}}
{{--                  <div class="card-body project">--}}
{{--                     <a href="{{ route('projects.show', $project->slug) }}" class="project-title h4">--}}
{{--                        {{ $project->title }}--}}
{{--                     </a>--}}
{{--                     <div class="details">--}}
{{--                        {!! Str::words($project->details, 10) !!}--}}
{{--                     </div>--}}
{{--                     <div class="section-cta">--}}
{{--                        <a href="{{ route('projects.show', $project->slug) }}" class="primary-btn {{ $customisation->button_style ?? '' }}">--}}
{{--                           Read More--}}
{{--                        </a>--}}
{{--                     </div>--}}
{{--                  </div>--}}
{{--               </div>--}}
{{--            </div>--}}
{{--         </div>--}}
         @endforeach
      @endif
      </div>
   </div>
</section>
