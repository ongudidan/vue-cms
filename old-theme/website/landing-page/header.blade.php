@if($customisation->top_header)
   @include('website.designs.shared.addon.header-tagline')
@endif
@if($customisation->header_style && $customisation->header_style !== 'default')
   @include('website.designs.shared.' . $customisation->header_style, ['customisation' => $customisation])
@else
   <header id="topnav" class="non-transparent defaultscroll sticky fixed-top sticky-top @if($customisation->top_header) tagline-height @endif">
      <div @class([
       $customisation->section_width_style ?? 'container',
       'w__' . ($customisation->section_width ?? '100') ])
      >
         <!-- Logo container-->
         <a class="logo" href="{{ route('home') }}">
      <span class="logo-light-mode">
         <img src="{{ $logo }}" class="l-dark" alt="Ecobiz Limited" style="max-height:40px;">
         <img src="{{ $footerLogo ?? $logo }}" class="l-light" alt="Ecobiz Limited" style="max-height:40px;">
      </span>
         </a>
         <!-- End Logo container-->
         <div class="menu-extras">
            <div class="menu-item">
               <!-- Mobile menu toggle-->
               <a class="navbar-toggle" id="isToggle" onclick="toggleMenu()">
                  <div class="lines">
                     <span></span>
                     <span></span>
                     <span></span>
                  </div>
               </a>
               <!-- End mobile menu toggle-->
            </div>
         </div>

         <div id="navigation">
            <!-- Navigation Menu-->
            <ul class="navigation-menu nav-center nav-light">
               @foreach($page->sections as $menu)
               @if(!empty($menu->spa_section_name))
               <li class="">
                  <a href="{{'#'.$menu->spa_section_id}}" class="sub-menu-item">
                     {{ $menu->spa_section_name }}
                  </a>
               </li>
               @endif
               @endforeach
            </ul>
         </div>
      </div>
   </header>
@endif

{{--@push('scripts')--}}
{{--    <script>--}}
{{--       function smoothScroll() {--}}
{{--          document.getElementById({{'#'.$menu->spa_section_id}}).scrollIntoView({--}}
{{--             behavior: "smooth"--}}
{{--          })--}}
{{--       }--}}
{{--    </script>--}}
{{--@endpush--}}
