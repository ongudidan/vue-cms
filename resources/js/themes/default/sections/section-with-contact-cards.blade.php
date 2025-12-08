<section class="section @if($section->section_has_map) mb-0 pb-0 @endif" id="{{$section->spa_section_id ?? ''}}">
   <div @class([
       $customisation->section_width_style ?? 'container',
       'w__' . ($customisation->section_width ?? '100') ])
   >
      @if($section->title)
         <div class="row justify-content-center text-center">
            @php
               $wordCount = str_word_count(strip_tags($section->details));
            @endphp
            <div class="@if($wordCount > 20) col-lg-10 @else col-lg-6 @endif col-12">
               <div class="mb-4">
                  @if($section->sub_title)
                     <p class="sub-title" data-aos="fade-in-up" data-aos-duration="1000" data-aos-delay="100">
                        {{ $section->sub_title }}
                     </p>
                  @endif
                  <h3 class="title"
                      data-aos="fade-in-up" data-aos-duration="1000" data-aos-delay="200">
                     {{ $section->title }}
                  </h3>
                  @if($section->details)
                     <div class="text-wrap details" data-aos="fade-in-up" data-aos-duration="1000" data-aos-delay="350">
                        {!! $section->details !!}
                     </div>
                  @endif
               </div>
            </div>
         </div>
      @endif
      <div class="row">
         <div class="col-lg-4 col-md-6 mx-auto" data-aos="zoom-in-up" data-aos-duration="1000" data-aos-delay="400">
            <div class="card border-0 p-4 text-center rounded features features-classic feature-primary mb-3">
               <i class="mdi mdi-phone-in-talk icon h1"></i>
               <div class="content">
                  <div class="title text-dark h5">Phone</div>
                  <div class="text-primary mb-0 mt-3">
                     <a href="tel:{{$company->primary_phone}}" class="text-primary">{{ $company->primary_phone ?? '' }}</a>
                     <a href="tel:{{$company->secondary_phone}}" class="text-primary">{{ $company->secondary_phone ?? '' }}</a>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-4 col-md-6 mx-auto" data-aos="zoom-in-up" data-aos-duration="1000" data-aos-delay="500">
            <div class="card border-0 p-4 text-center rounded features features-classic feature-primary mb-3">
               <i class="mdi mdi-email icon h1"></i>
               <div class="content">
                  <div class="title text-dark h5">Email</div>
                  <div class="text-primary mb-0 mt-3">
                     <a href="mailto:{{$company->email}}" class="text-primary">{{ $company->email ?? '' }}</a>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-4 col-md-6 mx-auto" data-aos="zoom-in-up" data-aos-duration="1000" data-aos-delay="600">
            <div class="card border-0 p-4 text-center rounded features features-classic feature-primary mb-3">
               <i class="mdi mdi-map-marker icon h1"></i>
               <div class="content">
                  <div class="title text-dark h5">Location</div>
                  <div class="text-primary mb-0 mt-3">
                     {{ $company->physical_address ?? '' }}
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   @if($section->section_has_map)
      <div class="container-fluid" data-aos="fade-in-up" data-aos-duration="1000" data-aos-delay="500">
         <div class="row">
            <div class="col-12 p-0">
               <div class="map">
                  {!! $section->map_link !!}
               </div>
            </div>
         </div>
      </div>
   @endif
</section>
