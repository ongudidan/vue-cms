<div class="col-12 mt-4 ps-2">
   <div class="ecm-product-category-slider-{{$section->id}}" data-aos="fade-up" data-aos-duration="1800" data-aos-delay="400">
      @php
      $categorizedProducts = $ecmProducts->filter(fn($product) =>
          $product->categories->contains('id', $section->section_link->linkable->id)
      )
      @endphp
      @foreach($categorizedProducts->take(10) as $key => $product)
         <div class="tiny-slide">
            <div class="card @if($section->section_has_bg) bg-transparent @endif shop-list border-0 mb-3">
               <div class="shop-image position-relative overflow-hidden shadow">
                  <a href="{{ route('ecm.products.show', $product->slug) }}">
                     <img src="{{ $product->media[0]->original_url ?? asset('website/dummy_1266x749.jpg.jpg') }}" class="img-fluid rounded" alt="{{ $product->slug }}">
                  </a>

                  <ul class="list-unstyled shop-icons">
                     <li>
                        <form id="addToCartForm-{{ $product->id }}" class="add-to-cart-form" method="POST" action="{{ route('cart.add') }}">
                           @csrf
                           <input type="hidden" name="product_id" value="{{ $product->id }}">
                           <input type="hidden" name="product_option_id" id="selected_option">
                           <input type="hidden" name="quantity" id="selected_quantity" value="1">
                           <input type="hidden" name="base_price" value="{{ $product->base_price }}">
                           <input type="hidden" name="option_adjusted_price" id="adjusted_price" value="0">
                           <input type="hidden" name="total_price" id="total_price" value="{{ $product->base_price }}">

                           <div class="mt-3">
                              <button id="submit-cart-{{$product->id}}" type="submit" class="btn {{ $customisation->button_style ?? '' }} btn-primary btn-icon btn-pills">
                                 <i class="uil uil-shopping-cart-alt icons"></i>
                              </button>
                           </div>
                        </form>
                     </li>
                  </ul>

                  <div class="qty-icons">
                     <button type="button" class="btn btn-icon btn-sm btn-primary minus">-</button>
                     <input min="1" name="quantity" value="1" type="number" class="form-control d-inline-block w__30 text-center quantity" disabled>
                     <button type="button" class="btn btn-icon btn-sm btn-primary plus">+</button>
                  </div>
               </div>
               <div class="card-body content pt-4 p-2">
                  <div class="d-block">
                     <a href="{{ route('ecm.products.show', $product->slug) }}" class="text-dark product-name h6 mb-0 align-middle">
                        {{ $product->name }}
                     </a>
                     <p class="text-success ms-auto small mb-0">
                        {{ $product->shop->currency->iso . ' ' . number_format(($product->base_price * 0.01), 0, 2) }}
                     </p>
                  </div>
{{--                  <div class="d-flex text-center mt-1">--}}
{{--                     <div class="text-dark details">{!! Str::words($product->description, 25) !!}</div>--}}
{{--                  </div>--}}
               </div>
            </div>
         </div>
      @endforeach
   </div>
</div>

@push('scripts')
   <script>
      document.addEventListener("DOMContentLoaded", function() {
         if(document.querySelector('.ecm-product-category-slider-{{$section->id}}')) {
            tns({
               container: '.ecm-product-category-slider-{{$section->id}}',
               controls: false,
               mouseDrag: true,
               loop: true,
               rewind: false,
               autoplay: true,
               autoplayButtonOutput: false,
               autoplayTimeout: 3000,
               navPosition: "bottom",
               speed: 400,
               gutter: 30,
               nav: true,
               controlsText: [
                  '<i class="mdi mdi-chevron-left"></i>',
                  '<i class="mdi mdi-chevron-right"></i>'
               ],
               responsive: {
                  992: {
                     items: 4
                  },

                  767: {
                     items: 2
                  },

                  320: {
                     items: 1
                  },
               },
            });
         }
      });
   </script>
@endpush
