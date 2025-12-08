<footer class="section section-bg footer {{ $customisation->footer_bg_color ?? 'bg-dark' }}">
   {{--   <div class="bg-overlay ">--}}
   {{--      <img src="{{ asset('website/images/backgrounds/T2.jpg') }}" alt="">--}}
   {{--   </div>--}}
   <div @class([
       $customisation->section_width_style ?? 'container',
       'w__' . ($customisation->section_width ?? '100') ])
   >
      <div class="row gy-3">
         <div class="col-xl-4 col-md-6 col-12">
            <a href="{{ route('home') }}">
               @if($company->has_footer_logo)
               <img src="{{ $footerLogo }}" alt="Ecobiz Limited" class="py-3" style="max-height:90px;">
               @else
               <img src="{{ $logo }}" alt="Ecobiz Limited" class="py-3" style="max-height:90px;">
               @endif
            </a>
            <p class="text-wrap">
               {{ $customisation->footer_text ?? 'CMS Website built by Ecobiz Limited' }}
            </p>
         </div>
         <div class="col-xl-2 col-md-6 col-12 offset-xl-1">
            <div class="footer-links ps-md-3" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
               <h5>Quick Links</h5>
               <ul class="footer-links">
                  @foreach($menus as $menu)
                  <li class="footer-link">
                     @if($menu->page)
                     <a href="{{ url($menu->page->slug ?? '#') }}">
                     @else
                     <a href="{{ url($menu->url ?? '#') }}">
                     @endif
                        <i class="mdi mdi-chevron-right"></i>
                        {{ $menu->title }}
                     </a>
                  </li>
                  @endforeach
               </ul>
            </div>
         </div>
         <div class="col-xl-2 col-md-6 col-12">
            <div class="footer-links" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
               <h5>Our Socials</h5>
               <ul class="footer-links">
                  <li class="footer-link">
                     <a href="{{ $company->ig_profile ?? '' }}" target="_blank">
                        <i class="ti ti-brand-instagram me-2 fw-bold text-secondary"></i> <span>Instagram</span>
                     </a>
                  </li>
                  <li class="footer-link">
                     <a href="{{ $company->fb_profile ?? '' }}" target="_blank">
                        <i class="ti ti-brand-facebook me-2 fw-bold text-secondary"></i> <span>Facebook</span>
                     </a>
                  </li>
                  <li class="footer-link">
                     <a href="{{ $company->x_profile ?? '' }}" target="_blank">
                        <i class="ti ti-brand-x me-2 fw-bold text-secondary"></i> <span>X</span>
                     </a>
                  </li>
                  @if($company->tiktok_profile)
                  <li class="footer-link">
                     <a href="{{ $company->tiktok_profile }}" target="_blank">
                        <i class="ti ti-brand-tiktok me-2 fw-bold text-secondary"></i> <span>Tiktok</span>
                     </a>
                  </li>
                  @endif
                  @if($company->pinterest_profile)
                  <li class="footer-link">
                     <a href="{{ $company->pinterest_profile }}" target="_blank">
                        <i class="ti ti-brand-pinterest me-2 fw-bold text-secondary"></i> <span>Pinterest</span>
                     </a>
                  </li>
                  @endif
                  @if($company->youtube_profile)
                     <li class="footer-link">
                        <a href="{{ $company->youtube_profile }}" target="_blank">
                           <i class="ti ti-brand-youtube me-2 fw-bold text-secondary"></i> <span>YouTube</span>
                        </a>
                     </li>
                  @endif
               </ul>
            </div>
         </div>
         <div class="col-xl-3 col-md-6 col-12">
            <div class="footer-contacts" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
               <h5>Get In Touch</h5>
               <div class="footer-contact">
                  <i class="mdi mdi-email"></i>
                  <a href="mailto:{{$company->email}}" >{{ $company->email ?? '' }}</a>
               </div>
               <div class="footer-contact">
                  <i class="mdi mdi-phone-in-talk"></i>
                  <div class="contact-details">
                     <a href="tel:{{$company->primary_phone}}" >{{ $company->primary_phone ?? '' }}</a>
                     <a href="tel:{{$company->secondary_phone}}" >{{ $company->secondary_phone ?? '' }}</a>
                  </div>
               </div>
               <div class="footer-contact">
                  <i class="mdi mdi-map-marker"></i>
                  <a href="#" >{{ $company->physical_address ?? '' }}</a>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div @class([
       $customisation->section_width_style ?? 'container',
       'w__' . ($customisation->section_width ?? '100') ])
   >
      <div class="copyright">
         <div class="row">
            <div class="col-md-6 col-12 mb-3 mb-md-0">
               <p>
                  <i class="mdi mdi-copyright"></i> {{ now()->format('Y') }} <a href="#" class="text-capitalize text-white">{{ $company->name ?? 'Ecobiz Limited' }}</a>
               </p>
            </div>
            <div class="col-12 col-md-6 mb-3 mb-md-0">
               <p class="text-right">Developed by: <a href="https://ecobiz.co.ke" class="text-white">Ecobiz Limited</a></p>
            </div>
         </div>
      </div>
   </div>
</footer>
