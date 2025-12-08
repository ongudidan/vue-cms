@php
   $backgroundImage = $section->media?->firstWhere('collection_name', 'section_bg');
   $sectionImage = $section->media?->firstWhere('collection_name', 'section_image');
@endphp
<section class="section @if($section->section_background_type === 'image-bg') section-bg @endif" id="{{$section->spa_section_id ?? ''}}">
   @if($section->section_has_bg)
   <div class="{{ $section->section_background_color ?? '' }}">
      @if($section->section_background_type === 'image-bg')
      <img src="{{ $backgroundImage->getUrl() ?? asset('website/images/backgrounds/T5.jpg') }}" alt="">
      @endif
   </div>
   @endif
      <div @class([
       $customisation->section_width_style ?? 'container',
       'w__' . ($customisation->section_width ?? '100'), 'mb-50' ])
      >
      <div class="row justify-content-center">
         @if($section->title && !$section->include_contact_cards)
         <div class="col-lg-5">
            <div class="text-start mb-4">
               @if($section->sub_title)
                  <p class="sub-title" data-aos="fade-right" data-aos-duration="1800" data-aos-delay="100">
                     {{ $section->sub_title }}
                  </p>
               @endif
               <h3 class="title" data-aos="fade-right" data-aos-duration="1800" data-aos-delay="200">
                  {{ $section->title }}
               </h3>
               <div class="text-wrap details" data-aos="fade-right" data-aos-duration="1800" data-aos-delay="350">
                  {!! $section->details !!}
               </div>
            </div>
         </div>
         @endif
         <div class="@if($section->include_contact_cards && !$section->title) col-lg-7 @elseif(!$section->include_contact_cards && !$section->title) col-lg-9 @else col-lg-7 @endif col-12 align-self-center">
            <div class="custom-form rounded mb-5 mb-lg-0 p-4" style="border: 1px solid #96a3bf;"
                 data-aos="zoom-up" data-aos-duration="1800" data-aos-delay="500">
               <form method="post" id="contactForm">
                  <p id="error-msg"></p>
                  <div id="simple-msg"></div>
                  <div class="row">
                     <div class="col-md-6 col-12">
                        <div class="form-group">
                           <label for="name">Name*</label>
                           <input name="name" id="name" type="text" class="form-control"
                                  placeholder="Your name...">
                           <div class="invalid-feedback text-danger"></div>
                        </div>
                     </div>
                     <div class="col-md-6 col-12">
                        <div class="form-group">
                           <label for="email">Email Address*</label>
                           <input name="email" id="email" type="email" class="form-control"
                                  placeholder="Your email...">
                           <div class="invalid-feedback text-danger"></div>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label for="subject">Subject*</label>
                           <input name="subject" id="subject" type="text" class="form-control"
                                  placeholder="Your subject...">
                           <div class="invalid-feedback text-danger"></div>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="form-group">
                           <label for="comments">Message*</label>
                           <textarea name="comments" id="comments" rows="4" class="form-control"
                                     placeholder="Your message..."></textarea>
                           <div class="invalid-feedback text-danger text-danger"></div>
                        </div>
                     </div>
                     <div class="col-12">
                        <button type="submit" id="submitContactForm" name="send" class="btn btn-primary {{ $customisation->button_style ?? '' }}">
                           <span class="btn-text">Send Message</span>
                           <i class="icon-size-15 ms-2 icon mdi mdi-send"></i>
                           <span class="spinner"></span>
                        </button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
         @if($section->include_contact_cards)
         <div class="col-lg-5 ">
            <div class="text-start mb-4 ms-lg-5">
               @if($section->sub_title)
                  <p class="sub-title" data-aos="fade-right" data-aos-duration="1800" data-aos-delay="100">
                     {{ $section->sub_title }}
                  </p>
               @endif
               <h3 class="title" data-aos="fade-right" data-aos-duration="1800" data-aos-delay="200">
                  {{ $section->title }}
               </h3>
               <div class="text-wrap details" data-aos="fade-right" data-aos-duration="1800" data-aos-delay="350">
                  {!! $section->details !!}
               </div>
            </div>
            <div class="contact-detail ms-lg-5">
               <p class="">
                  <i class="icon-xxl icon me-1 mdi mdi-email"></i> :<span>{{ $company->email }}</span>
               </p>
               <p class="">
                  <i class="icon-xxl icon me-1 mdi mdi-link"></i> : <span>{{ $company->website }}</span>
               </p>
               <p class="">
                  <i class="icon-xxl icon me-1 mdi mdi-phone-in-talk"></i> :
                  <span>{{ $company->primary_phone }} @if($company->secondary_phone) | {{ $company->secondary_phone }}@endif</span>
               </p>
               <p class="">
                  <i class="icon-xxl icon me-1 mdi mdi-pin"></i> : <span class="text-wrap">{{ $company->physical_address }}</span>
               </p>
            </div>
         </div>
         @endif
      </div>
   </div>
   @if($section->section_has_map)
   <div class="container-fluid">
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

@push('scripts')
   <script src="{{ asset('website/js/contact.js') }}"></script>
@endpush
