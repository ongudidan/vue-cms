<section class="section team" id="{{$section->spa_section_id ?? ''}}" style="z-index: 1;">
   <div @class([
       $customisation->section_width_style ?? 'container',
       'w__' . ($customisation->section_width ?? '100') ])
   >
      <div class="row justify-content-center">
         <div class="col-lg-7">
            <div class="text-center mb-5">
               @if($section->sub_title)
               <p class="sub-title" data-aos="fade-in-up" data-aos-duration="1000" data-aos-delay="100">
                  {{ $section->sub_title }}
               </p>
               @endif
               <h2 class="title" data-aos="fade-in-up" data-aos-duration="1000" data-aos-delay="200">
                  {{ $section->title }}
               </h2>
               <div class="details" data-aos="fade-in-up" data-aos-duration="1000" data-aos-delay="300">
                  {!! $section->details !!}
               </div>
            </div>
         </div>
      </div>
      <div class="row gy-4 mb-3">
         @foreach($board_members->take(4) as $key => $member)
         <div class="col-lg-3 col-sm-6">
            <div class="team-card">
               <div class="team-card-img">
                  <img class="img-fluid" src="{{ $member->media[0]->original_url ?? asset('website/dummy_450x450.jpg') }}" alt="image" >
               </div>
               <div class="team-card-text-2">
                  <h5 class="fw-bold mb-0">{{ $member->name }}</h5>
                  <p class="mb-0 fs-13">{{ $member->position }}</p>
               </div>
            </div>
         </div>
         @endforeach
      </div>
      <div class="row justify-content-center">
         <div class="col-lg-7">
            <div class="text-center">
            @foreach($section->cta_buttons as $button)
               <a href="{{ url($button->page->slug ?? '#') }}" class="btn {{ $button->cta_button_type . ' ' . $customisation->button_style ?? '' }}"
                     data-aos="zoom-in-up" data-aos-duration="1000" data-aos-delay="{{ ($key + 1) * 400 }}">
                  {{ $button->cta_button_text }}
               </a>
            @endforeach
            </div>
         </div>
      </div>
   </div>
</section>
