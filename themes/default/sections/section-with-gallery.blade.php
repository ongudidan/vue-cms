@push('styles')
   <link href="{{ asset('/website/css/tobii.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

<section class="section" id="{{$section->spa_section_id ?? ''}}">
   <div @class([
             $customisation->section_width_style ?? 'container',
             'w__' . ($customisation->section_width ?? '100')
          ])
   >
      <div id="grid" class="row">
         @php
            $sectionGallery = $section->media->where('collection_name', 'section-gallery');
         @endphp
         @foreach($sectionGallery as $gallery)
            <div class="col-md-3 col-12 spacing picture-item" data-groups='["section-gallery"]'>
               <div class="card portfolio portfolio-masonry portfolio-primary rounded-0 overflow-hidden">
                  <div class="card-img position-relative">
                     <img src="{{ $gallery->original_url ?? null }}" class="img-fluid w-100" alt=""
                          style="height: 300px; object-fit: cover; object-position: center;">
                     <div class="card-overlay"></div>

                     <div class="content text-center pop-icon">
                        <a href="{{ $gallery->original_url ?? null }}"
                           data-lightbox="service-gallery" class="btn btn-pills btn-icon lightbox">
                           <i class="uil uil-search"></i>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         @endforeach
      </div>
   </div>
</section>
