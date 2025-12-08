{{--
   TOP HEADER / TAGLINE SECTION
   This section controls the small top bar that shows email, phone, and social icons.
--}}

<div class="tagline 
    {{-- If a custom background class exists, use it. Otherwise use bg-light --}}
    @if($customisation->top_header_bg) 
        {{$customisation->top_header_bg}} 
    @else 
        bg-light 
    @endif
">

   {{--
        Dynamic container width.
        We use @class() helper to apply classes based on conditions.
    --}}
   <div @class([
      // Width style (container / container-fluid / custom)
      $customisation->section_width_style ?? 'container',

      // Custom width class (example: w__100)
      'w__' . ($customisation->section_width ?? '100')
      ])>

      <div class="row">
         <div class="col-12">

            <div class="d-flex align-items-center justify-content-between">

               {{-- ============================
                         LEFT SIDE — EMAIL & PHONE
                       ============================ --}}
               <ul class="list-unstyled mb-0">

                  {{-- COMPANY EMAIL --}}
                  <li class="list-inline-item mb-0">
                     <a href="mailto:{{$company->email ?? 'javascript:void(0)'}}" class="text-dark">
                        <i class="mdi mdi-email icon-lg me-2"></i>
                        {{-- Show email text or empty if missing --}}
                        {{ $company->email ?? '' }}
                     </a>
                  </li>

                  {{-- COMPANY PHONE --}}
                  <li class="list-inline-item mb-0 ms-3">
                     <a href="tel:{{$company->primary_phone ?? 'javascript:void(0)'}}" class="text-dark">
                        <i class="mdi mdi-phone me-2"></i>
                        {{-- Show phone number --}}
                        {{ $company->primary_phone ?? '' }}
                     </a>
                  </li>

               </ul>

               {{-- ============================
                         RIGHT SIDE — SOCIAL ICONS
                       ============================ --}}
               <ul class="list-unstyled social-icon tagline-social mb-0">

                  {{-- Instagram (always shown, fallback to #) --}}
                  <li class="list-inline-item mb-0">
                     <a href="{{ $company->ig_profile ?? '#' }}" target="_blank">
                        <i class="ti ti-brand-instagram mb-0"></i>
                     </a>
                  </li>

                  {{-- Facebook --}}
                  <li class="list-inline-item mb-0">
                     <a href="{{ $company->fb_profile ?? '#' }}" target="_blank">
                        <i class="ti ti-brand-facebook mb-0"></i>
                     </a>
                  </li>

                  {{-- X (Twitter) --}}
                  <li class="list-inline-item mb-0">
                     <a href="{{ $company->x_profile ?? '#' }}" target="_blank">
                        <i class="ti ti-brand-x mb-0"></i>
                     </a>
                  </li>

                  {{-- TikTok (only show if link exists) --}}
                  @if($company->tiktok_profile)
                  <li class="list-inline-item mb-0">
                     <a href="{{ $company->tiktok_profile }}" target="_blank">
                        <i class="ti ti-brand-tiktok mb-0"></i>
                     </a>
                  </li>
                  @endif

                  {{-- Pinterest --}}
                  @if($company->pinterest_profile)
                  <li class="list-inline-item mb-0">
                     <a href="{{ $company->pinterest_profile }}" target="_blank">
                        <i class="ti ti-brand-pinterest mb-0"></i>
                     </a>
                  </li>
                  @endif

                  {{-- YouTube --}}
                  @if($company->youtube_profile)
                  <li class="list-inline-item mb-0">
                     <a href="{{ $company->youtube_profile }}" target="_blank">
                        <i class="ti ti-brand-youtube mb-0"></i>
                     </a>
                  </li>
                  @endif

               </ul>
            </div>
         </div>
      </div>
   </div>
</div>