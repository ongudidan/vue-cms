@if($customisation->footer_style && $customisation->footer_style !== 'default')
   @include('website.designs.shared.' . $customisation->footer_style, ['customisation' => $customisation])
@else
   <footer class="section footer @if($customisation->footer_bg_color) {{$customisation->footer_bg_color}} @else bg-dark @endif">
      <div @class([
          $customisation->section_width_style ?? 'container',
          'w__' . ($customisation->section_width ?? '100') ])
      >
         <div class="row justify-content-center">
            <div class="col-lg-6 col-sm-10 text-center">
               <a href="{{ route('home') }}">
                  @if($company->has_footer_logo)
                  <img src="{{ $footerLogo }}" alt="Ecobiz Limited" style="max-height:100px;width:auto;">
                  @else
                  <img src="{{ $logo }}" alt="Ecobiz Limited" style="max-height:100px; min-width:200px;">
                  @endif
               </a>
               <ul class="list-unstyled mb-0 mt-4 social-icon">
                  <li class="list-inline-item mb-0"><a href="{{ $company->ig_profile ?? '' }}"><i class="ti ti-brand-instagram mb-0"></i></a></li>
                  <li class="list-inline-item mb-0"><a href="{{ $company->fb_profile ?? '' }}"><i class="ti ti-brand-facebook mb-0"></i></a></li>
                  <li class="list-inline-item mb-0"><a href="{{ $company->x_profile ?? '' }}"><i class="ti ti-brand-x mb-0"></i></a></li>
                  @if($company->tiktok_profile)
                  <li class="list-inline-item mb-0"><a href="{{ $company->tiktok_profile }}"><i class="ti ti-brand-tiktok mb-0"></i></a></li>
                  @endif
                  @if($company->pintrest_profile)
                  <li class="list-inline-item mb-0"><a href="{{ $company->pintrest_profile }}"><i class="ti ti-brand-pinterest mb-0"></i></a></li>
                  @endif
                  @if($company->youtube_profile)
                  <li class="list-inline-item mb-0"><a href="{{ $company->youtube_profile }}"><i class="ti ti-brand-youtube mb-0"></i></a></li>
                  @endif
               </ul>
            </div>
         </div>
         <div class="row justify-content-center">
            <div class="col-lg-12">
               <div class="text-center mt-3">
                  <ul class="list-unstyled mb-0">
                     @foreach($menus as $menu)
                        <li class="list-inline-item mx-lg-3 m-2">
                           <a class="text-white" href="@if($menu->page) {{ url($menu->page->slug) }} @else {{ url($menu->url) }} @endif">
                              {{ $menu->title }}
                           </a>
                        </li>
                     @endforeach
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </footer>
   <div class="footer-alt py-3 {{ $customisation->footer_bg_color ?? 'bg-dark' }}">
      <div @class([
          $customisation->section_width_style ?? 'container',
          'w__' . ($customisation->section_width ?? '100') ])
      >
         <div class="row">
            <div class="col-lg-12">
               <div class="text-center">
                  <p class="text-white font-size-15 mb-0">
                     {{ now()->format('Y') }} © {{ $company->name ?? 'Ecobiz Limited' }}. Developed By
                     <a href="https://www.ecobiz.co.ke" target="_blank">Ecobiz Limited</a>
                  </p>
               </div>
            </div>
         </div>
      </div>
   </div>
@endif
