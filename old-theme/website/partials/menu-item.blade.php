<li class="{{ $menu->children->isNotEmpty() ? 'has-submenu ' . ($menu->parent_id ? 'parent-menu-item' : 'parent-parent-menu-item') : '' }}
           @if(request()->is($menu->page->slug . '*')) active @endif">

   <a href="{{ $menu->page ? url($menu->page->slug) : 'javascript:void(0)' }}">
      {{ $menu->title }}
   </a>

   @if($menu->children->isNotEmpty())
      <span class="{{ $menu->parent_id ? 'submenu-arrow' : 'menu-arrow' }}"></span>
      <ul class="submenu">
         @foreach($menu->children as $child)
            @include('website.partials.menu-item', ['menu' => $child])
         @endforeach
      </ul>
   @endif
</li>
