<section class="section" id="{{$section->spa_section_id ?? ''}}">
   @if($section->section_has_bg)
      <div class="{{ $section->section_background_color ?? '' }}">
         @if($section->section_background_type === 'image-bg')
            <img src="{{ $backgroundImage->getUrl() ?? asset('website/dummy_1266x749.jpg') }}" alt="">
         @endif
      </div>
   @endif
   <div @class([
       $customisation->section_width_style ?? 'container',
       'w__' . ($customisation->section_width ?? '100') ])
   >
      <div class="row">
         <div class="col-12 justify-content-center text-center">
            @if($section->sub_title)
               <p class="sub-title" data-aos="fade-right" data-aos-duration="800" data-aos-delay="100">
                  {{ $section->sub_title }}
               </p>
            @endif
            <h3 class="title mb-3" data-aos="fade-right" data-aos-duration="800" data-aos-delay="200">
               {{ $section->title }}
            </h3>
            <div class="details mb-3" data-aos="fade-right" data-aos-duration="800" data-aos-delay="600">
               {!! $section->details ?? '' !!}
            </div>
         </div>
         <div class="col-md-7 mx-auto">
            <div class="tab-content" id="pills-tabContent">
               <div class="tab-pane fade show active" id="pills-buying" role="tabpanel" aria-labelledby="pills-buying-tab">
                  <div class="accordion mt-md-0 mt-3" id="frequentlyAskedQuestion">
                     @foreach($section->section_faqs as $key => $faq)
                        <div class="accordion-item rounded border-0 shadow mb-3" data-aos="zoom-in-up" data-aos-duration="1000" data-aos-delay="{{ ($key + 1) * 200 }}">
                           <h2 class="accordion-header" id="{{ $key }}">
                              <button class="accordion-button border-0 bg-white" type="button" data-bs-toggle="collapse"
                                      data-bs-target="#faq-{{ $key }}" aria-expanded="true" aria-controls="faq-{{ $key }}">
                                 {{ $faq->question }}
                              </button>
                           </h2>
                           <div id="faq-{{ $key }}" class="accordion-collapse border-0 collapse" aria-labelledby="{{ $key }}"
                                data-bs-parent="#frequentlyAskedQuestion">
                              <div class="accordion-body bg-white">
                                 {!! $faq->answer !!}
                              </div>
                           </div>
                        </div>
                     @endforeach
                  </div>
               </div>
            </div>
         </div>

         <div class="col-12 justify-content-center text-center">
            <div class="mb-3">
               @if($section->has_cta_buttons && $section->cta_buttons->isNotEmpty())
                  @foreach($section->cta_buttons as $button)
                     <a href="{{ url($button->page->slug ?? 'javascript:void(0)') }}" data-aos="fade-right" data-aos-duration="1000" data-aos-delay="800"
                        class="btn {{ $button->cta_button_type . ' ' . $customisation->button_style ?? '' }} me-2 mb-3">
                        {{ $button->cta_button_text }}
                     </a>
                  @endforeach
               @endif
            </div>
         </div>
      </div>
   </div>
</section>
