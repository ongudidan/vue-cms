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
      <div class="row justify-content-center text-md-start text-center">
         <div class="col-md-7 col-12 mx-auto justify-content-center text-center">
            @if($section->sub_title)
               <p class="sub-title" data-aos="fade-right" data-aos-duration="800" data-aos-delay="100">
                  {{ $section->sub_title }}
               </p>
            @endif
            <h3 class="title" data-aos="fade-right" data-aos-duration="800" data-aos-delay="200">
               {{ $section->title }}
            </h3>
            <div class="details mb-3" data-aos="fade-right" data-aos-duration="800" data-aos-delay="600">
               {!! $section->details ?? '' !!}
            </div>
         </div>

         <div class="col-md-6 col-12">
            <div class="tab-content" id="faqs-1-tabContent">
               <div class="tab-pane fade show active" id="faqs-1" role="tabpanel" aria-labelledby="faqs-1-tab">
                  <div class="accordion mt-4 pt-2" id="sectionFaqs-{{$section->id}}">
                     @foreach($section->section_faqs as $key => $faq)
                        @if($loop->odd)
                           <div class="accordion-item rounded border-0 shadow mb-3" data-aos="zoom-in-up" data-aos-duration="1000" data-aos-delay="{{ $key * 200 }}">
                              <h2 class="accordion-header" id="{{ $faq->id }}">
                                 <button class="accordion-button border-0 bg-white" type="button" data-bs-toggle="collapse"
                                         data-bs-target="#faq-{{ $faq->id }}" aria-expanded="true" aria-controls="faq-{{ $faq->id }}">
                                    {{ $faq->question }}
                                 </button>
                              </h2>
                              <div id="faq-{{ $faq->id }}" class="accordion-collapse border-0 collapse" aria-labelledby="{{ $faq->id }}"
                                   data-bs-parent="#sectionFaqs-{{$faq->id}}">
                                 <div class="accordion-body text-muted bg-white">
                                    {!!  $faq->answer !!}
                                 </div>
                              </div>
                           </div>
                        @endif
                     @endforeach
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-6 col-12">
            <div class="tab-content" id="faqs-2-tabContent">
               <div class="tab-pane fade show active" id="faqs-2" role="tabpanel" aria-labelledby="faqs-2-tab">
                  <div class="accordion mt-4 pt-2" id="sectionFaqs-{{$section->id}}">
                     @foreach($section->section_faqs as $key => $faq)
                        @if($loop->even)
                           <div class="accordion-item rounded border-0 shadow mb-3" data-aos="zoom-in-up" data-aos-duration="1000" data-aos-delay="{{ $key * 200 }}">
                              <h2 class="accordion-header" id="{{ $faq->id }}">
                                 <button class="accordion-button border-0 bg-white" type="button" data-bs-toggle="collapse"
                                         data-bs-target="#faq-{{ $faq->id }}" aria-expanded="true" aria-controls="faq-{{ $faq->id }}">
                                    {{ $faq->question }}
                                 </button>
                              </h2>
                              <div id="faq-{{ $faq->id }}" class="accordion-collapse border-0 collapse" aria-labelledby="{{ $faq->id }}"
                                   data-bs-parent="#sectionFaqs-{{$faq->id}}">
                                 <div class="accordion-body text-muted bg-white">
                                    {!!  $faq->answer !!}
                                 </div>
                              </div>
                           </div>
                        @endif
                     @endforeach
                  </div>
               </div>
            </div>
         </div>

         <div class="col-12">
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
