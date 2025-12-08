<section class="section" id="{{$section->spa_section_id ?? ''}}">
   <div @class([
       $customisation->section_width_style ?? 'container',
       'w__' . ($customisation->section_width ?? '100') ])
   >
      <div class="row">
         <div class="col-md-10 col-12">
            <div class="mb-4 text-center">
               @if($section->sub_title)
                  <p class="sub-title" data-aos="fade-in-up" data-aos-duration="1000" data-aos-delay="100">
                     {{ $section->sub_title }}
                  </p>
               @endif
               <h3 class="title" data-aos="fade-in-up" data-aos-duration="1000" data-aos-delay="200">
                  {{ $section->title }}
               </h3>
               <div class="details" data-aos="fade-in-up" data-aos-duration="1000" data-aos-delay="300">
                  {!! $section->details !!}
               </div>
               @foreach($section->cta_buttons as $key => $button)
                  <a href="{{ url($button->page->slug ?? '#') }}" class="btn {{ $button->cta_button_type . ' ' . $customisation->button_style ?? '' }}"
                     data-aos="zoom-in-up" data-aos-duration="1000" data-aos-delay="{{ ($key + 1) * 400 }}">
                     {{ $button->cta_button_text }}
                  </a>
               @endforeach
            </div>
         </div>
         @foreach($blogs as $key => $blog)
         <div class="col-lg-6 mb-4 pb-2">
            <div class="card blog blog-primary shadow rounded overflow-hidden" data-aos="zoom-in-up" data-aos-duration="1000" data-aos-delay="{{ ($key + 1) * 300 }}">
               <div class="row align-items-center g-0">
                  <div class="col-md-6">
                     <div class="image card-img position-relative overflow-hidden">
                        <img src="{{ $blog->media[0]->original_url ?? asset('website/dummy_800x600.jpg') }}"
                             class="img-fluid" alt="{{$blog->slug}}" style="width: 273px; height:204px;">
                        <div class="card-overlay"></div>
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="card-body content">
                        <a href="{{ route('blogs.show', $blog->slug) }}" class="h5 text-dark d-block mb-0">
                           {{ $blog->title }}
                        </a>
                        <div class="mt-2 mb-2 details">
                           {!! Str::words($blog->details, 9) !!}
                        </div>
                        <a href="{{ route('blogs.show', $blog->slug) }}" class="link text-dark">
                           Read More<i class="uil uil-arrow-right align-middle"></i>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         @endforeach
      </div>
   </div>
</section>
