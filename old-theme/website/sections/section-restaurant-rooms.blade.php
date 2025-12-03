@php
   $wordCount = str_word_count(strip_tags($section->details));
   $backgroundImage = $section->media?->firstWhere('collection_name', 'section_bg');
   $sectionImage = $section->media?->firstWhere('collection_name', 'section_image');
@endphp
<section class="section @if($section->section_has_bg) section-bg section-bg-fixed @endif">
   @if($section->section_has_bg)
   <div class="{{ $section->section_background_color ?? 'bg-overlay ' }}">
      @if($section->section_background_type === 'image-bg')
         <img src="{{ $backgroundImage->getUrl() ?? asset('website/images/backgrounds/T5.jpg') }}" alt="">
      @endif
   </div>
   @endif
      <div @class([
             $customisation->section_width_style ?? 'container',
             'w__' . ($customisation->section_width ?? '100')
          ])
      >
         <div class="@if($wordCount > 20) col-lg-10 @else col-lg-6 @endif col-12">
            <div class="mb-4">
               @if($section->sub_title)
                  <p class="sub-title" data-aos="fade-up" data-aos-duration="1800" data-aos-delay="100">
                     {{ $section->sub_title }}
                  </p>
               @endif
               <h3 class="title" data-aos="fade-up" data-aos-duration="1800" data-aos-delay="200">
                  {{ $section->title }}
               </h3>
               <div class="text-muted details" data-aos="fade-up" data-aos-duration="1800" data-aos-delay="300">
                  {!! $section->details !!}
               </div>
               @foreach($section->cta_buttons as $key => $button)
                  <a href="{{ url($button->page->slug ?? '#') }}" class="btn {{ $button->cta_button_type . ' ' . $customisation->button_style ?? '' }}"
                     data-aos="zoom-in-up" data-aos-duration="1800" data-aos-delay="{{ ($key + 1) * 300 }}">
                     {{ $button->cta_button_text }}
                  </a>
               @endforeach
            </div>
         </div>
         <div class="col-md-10 mx-auto">
            <div class="rst-restaurant-room-slider-{{$section->id}}">
            @foreach($rstRooms->take(5) as $room)
               <div class="tiny-slide">
                  <div class="row">
                     <div class="col-12 mb-4 bg-light">
                        <div class="row">
                           <div class="col-lg-6 align-self-center">
                              <div class="ps-3">
                                 <a href="{{ route('rooms.show', $room->slug) }}" class="h4 text-dark mb-3 d-block title">
                                    {{ $room->name }}
                                 </a>

                                 <div class="text-muted mt-2 mb-2 details room">
                                    {!! Str::limit($room->description ?? '', 200) !!}
                                 </div>

                                 <div class="d-flex gap-3 mb-3">
                                 <span class="badge bg-white text-dark">
                                     <i class="ti ti-users-group fs-5 text-primary me-2"></i> Up to {{$room->capacity}} guest(s)
                                 </span>
                                    @if($room->area_sqm)
                                       <span class="badge bg-white text-dark">
                                   <i class="ti ti-ruler fs-5 text-primary me-2"></i> {{$room->area_sqm}} m²
                                 </span>
                                    @endif
                                 </div>

                                 <div class="mb-3">
                                    @foreach($room->amenities as $amenity)
                                       <i class="mdi {{ $amenity->icon ?? 'mdi mdi-check-circle' }} text-primary me-1 fs-5"
                                          title="{{$amenity->name}}"></i>
                                    @endforeach
                                 </div>

                                 <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('rooms.show', $room->slug) }}" class="btn btn-sm btn-primary rounded-0">
                                       Read More
                                    </a>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-6 ps-0">
                              <div class="img-wrapper">
                                 <img src="{{ $room->getFirstMediaUrl('room-images') ?: asset('website/dummy_1266x749.jpg') }}"
                                      alt="{{$room->slug}}" class="img-fluid"
                                      style="object-fit:cover;object-position:center;display:block;min-height:330px;">
                              </div>
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
</section>

@push('scripts')
   <script>
      document.addEventListener("DOMContentLoaded", function() {
         if(document.querySelector('.rst-restaurant-room-slider-{{$section->id}}')) {
            tns({
               container: '.rst-restaurant-room-slider-{{$section->id}}',
               controls: true,
               mouseDrag: true,
               loop: true,
               rewind: false,
               autoplay: true,
               autoplayButtonOutput: false,
               autoplayTimeout: 6000,
               navPosition: "bottom",
               speed: 1500,
               gutter: 12,
               nav: true,
               controlsText: [
                  '<i class="mdi mdi-chevron-left"></i>',
                  '<i class="mdi mdi-chevron-right"></i>'
               ],
               responsive: {
                  992: {
                     items: 1
                  },

                  767: {
                     items: 1
                  },

                  320: {
                     items: 1
                  },
               },
            });
         }
      });
   </script>
@endpush
