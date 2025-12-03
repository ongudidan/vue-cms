<header id="topnav" class="defaultscroll sticky @if($customisation->top_header) tagline-height @endif">
   <div @class([
       $customisation->section_width_style ?? 'container',
       'w__' . ($customisation->section_width ?? '100') ])
   >
      <!-- Logo container-->
      <a class="logo" href="{{ route('home') }}">
         <span class="logo-light-mode">
            <img src="{{ $logo }}" class="l-dark" alt="Ecobiz Limited" style="max-height:60px;">
            <img src="{{ $footerLogo ?? $logo }}" class="l-light" alt="Ecobiz Limited" style="max-height:60px;">
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

      @if($ecommerceEnabled === 'YES')
      <ul class="buy-button list-inline mb-0">
         <li class="list-inline-item search-icon mb-0">
            <div class="dropdown">
               <button type="button" class="btn text-primary dropdown-toggle mb-0 p-0 bg-transparent" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="ti ti-search fs-4 mb-0 text-blue"></i>
               </button>
               <div class="dropdown-menu dd-menu dropdown-menu-start bg-white shadow rounded border-0 mt-4 py-0" style="width: 300px;">
                  <form action="{{ route('ecm.products.search') }}" method="get" class="p-4">
                     <input type="text" id="s" name="s" class="form-control border bg-white" placeholder="Search...">
                  </form>
               </div>
            </div>
         </li>

         <li class="list-inline-item search-icon mb-0">
            <a href="{{ route('customer.login') }}">
               <i class="ti ti-user-filled fs-4 mb-0"></i>
            </a>
         </li>

         <li class="list-inline-item search-icon mb-0">
            <a href="{{ route('cart.show') }}">
               <i class="ti ti-shopping-bag fs-4 mb-0"></i>
               <span class="cart-count translate-middle badge rounded-pill bg-danger ms-2" id="cart-count">
                  {{ $cartCount }}
               </span>
            </a>
         </li>
      </ul>
      @endif

      <div id="navigation">
         <!-- Navigation Menu-->
         <ul class="navigation-menu nav-right nav-light">
            @foreach($menus as $menu)
               @if($menu->type === 'page' && $menu->has_children && $menu->child_type === 'pages')
                  <li class="has-submenu parent-parent-menu-item {{ $menu->hasActiveChild() ? 'active' : '' }}">
                     <a href="{{ url($menu->page?->slug ?? '#') }}">
                        {{ $menu->title }}
                     </a>
                     <span class="menu-arrow"></span>
                     <ul class="submenu">
                        @foreach($menu->children as $child)
                           <li class="">
                              <a href="{{ url($child->page?->slug ?? '#') }}" class="sub-menu-item @if(request()->is('/' . $child->page?->slug . '*')) active @endif">
                                 {{ $child->title }}
                              </a>
                           </li>
                        @endforeach
                     </ul>
                  </li>
               @elseif($menu->type === 'page' && $menu->has_children && $menu->child_type === 'component')
                  @php
                     $component = $menu->component;
                     $items = $component::where('active', true)->orderBy('id')->get();
                     $baseRoute = $component === 'App\\Models\\Service' ? 'services' : 'projects';
                  @endphp
                  <li class="has-submenu parent-parent-menu-item @if(request()->is('/' . $baseRoute . '*')) active @endif">
                     <a href="{{ url($menu->page?->slug) ?? '#' }}">{{ $menu->title }}</a><span class="menu-arrow"></span>
                     <ul class="submenu">
                        @foreach($items as $item)
                           <li>
                              <a href="{{ route("$baseRoute.show", $item->slug) }}" class="sub-menu-item @if(request()->is("$baseRoute/{$item->slug}")) active @endif">
                                 {{ $item->title }}
                              </a>
                           </li>
                        @endforeach
                     </ul>
                  </li>
               @elseif($menu->type === 'custom' && $menu->has_children && $menu->child_type === 'pages')
                  <li class="has-submenu parent-parent-menu-item @if(request()->is($menu->url . '*')) active @endif">
                     <a href="{{ $menu->url ?? 'javascript:void(0)' }}">{{ $menu->title }}</a><span class="menu-arrow"></span>
                     <ul class="submenu">
                        @foreach($menu->children as $child)
                           <li class="has-submenu parent-menu-item">
                              <a href="{{ url($child->page->slug) }}">{{ $child->title }}</a>
                           </li>
                        @endforeach
                     </ul>
                  </li>
               @elseif($menu->type === 'custom' && $menu->has_children && $menu->child_type === 'component')
                  @php
                     $component = $menu->component;
                     $items = $component::where('active', true)->orderBy('id')->get();
                     $baseRoute = $component === 'App\\Models\\Service' ? 'services' : 'projects';
                  @endphp
                  <li class="has-submenu parent-parent-menu-item @if(request()->is($menu->url . '*')) active @endif">
                     <a href="{{ $menu->url ?? 'javascript:void(0)' }}">{{ $menu->title }}</a><span class="menu-arrow"></span>
                     <ul class="submenu">
                        @foreach($items as $item)
                           <li>
                              <a href="{{ route("$baseRoute.show", $item->slug) }}" class="sub-menu-item @if(request()->is("$baseRoute/{$item->slug}")) active @endif">
                                 {{ $item->title }}
                              </a>
                           </li>
                        @endforeach
                     </ul>
                  </li>
               @else
                  <li class="@if($menu->page && request()->is($menu->page?->slug.'*') || $menu->url && request()->is($menu->url.'*')) active @endif">
                     <a href="{{ url($menu->page?->slug ?? '#') }}" class="sub-menu-item">
                        {{ $menu->title }}
                     </a>
                  </li>
               @endif
            @endforeach
         </ul>
      </div>
   </div>
</header>
