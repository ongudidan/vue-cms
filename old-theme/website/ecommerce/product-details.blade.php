@extends('website.index')

@push('meta_tags')
   {!! SEOTools::generate() !!}
@endpush

@section('content')
   @include('website.shared.page-banner', ['parent' => $page ?? null, 'title' => $product->name])

   <section class="section">
      <div @class([
             $customisation->section_width_style ?? 'container',
             'w__' . ($customisation->section_width ?? '100')
          ])
      >
         <div class="row">
            <div class="col-md-5">
               @php
                  $productGallery = $product->media->where('collection_name', 'product_images');
               @endphp
               @if(isset($productGallery))
                  <div class="tiny-single-item">
                     @foreach($productGallery as $media)
                        <div class="tiny-slide">
                           <img src="{{ $media->original_url ?? asset('website/dummy_450x450.jpg') }}" alt="{{$product->slug}}"
                                class="img-fluid rounded" style="max-height: 500px;width: 100% !important;object-fit: cover !important;object-position: center !important;">
                        </div>
                     @endforeach
                  </div>
               @else
                  {{--                  <div class=""></div>--}}
                  <img src="{{ asset('website/dummy_450x450.jpg') }}" class="img-fluid rounded" alt="">
               @endif
            </div>

            <div class="col-md-7 mt-4 mt-sm-0 pt-2 pt-sm-0">
               <div class="section-title ms-md-4">
                  <h5 class="text-dark">{{ $product->name }}</h5>
                  <p class="text-success fw-bold mb-0 price">{{ $product->shop->currency->iso . ' ' . number_format(($product->base_price * 0.01), 0, 2) }}</p>

                  <h5 class="mt-2 mb-0">Overview :</h5>
                  <div class="text-muted">{!! $product->description ?? '' !!}</div>

                  <div class="row mt-4 pt-2">
                     <div class="col-lg-12 col-12">
                        <div class="d-flex shop-list align-items-center mb-3">
                           @php
                              $groupedOptions = $product->variants->groupBy(function($option) {
                                  return $option->variant->name ?? 'Other';
                              });
                           @endphp
                           @foreach($groupedOptions as $variantName => $options)
                              <h5 class="mb-0">{{ $variantName }}:</h5>
                              <ul class="list-unstyled shop-icons mb-0 ms-3">
                                 @foreach($options as $option)
                                    <li class="list-inline-item options">
                                       <a href="javascript:void(0)"
                                          class="btn btn-sm btn-soft-primary option-btn"
                                          data-option-id="{{ $option->id }}"
                                          data-adjusted-price="{{ $option->price_adjustment ?? 0 }}">
                                          {{ $option->name }}
                                       </a>
                                    </li>
                                 @endforeach
                              </ul>
                           @endforeach
                        </div>
                     </div>

                     <div class="col-lg-12 col-12 mt-4 mt-lg-0">
                        <div class="d-flex shop-list align-items-center mb-3">
                           <h5 class="mb-0">Quantity:</h5>
                           <div class="qty-icons ms-3">
                              <button type="button" class="btn btn-icon btn-sm btn-primary minus">-</button>
                              <input min="1" name="quantity" value="1" type="number" class="form-control d-inline-block w__30 text-center quantity">
                              <button type="button" class="btn btn-icon btn-sm btn-primary plus">+</button>
                           </div>
                        </div>
                     </div>
                  </div>

                  <form id="addToCartForm-{{ $product->id }}" class="add-to-cart-form" method="POST" action="{{ route('cart.add') }}">
                     @csrf
                     <input type="hidden" name="product_id" value="{{ $product->id }}">
                     <input type="hidden" name="product_option_id" id="selected_option">
                     <input type="hidden" name="quantity" id="selected_quantity" value="1">
                     <input type="hidden" name="base_price" value="{{ $product->base_price }}">
                     <input type="hidden" name="option_adjusted_price" id="adjusted_price" value="0">
                     <input type="hidden" name="total_price" id="total_price" value="{{ $product->base_price }}">

                     <div class="mt-3">
                        <button id="submit-cart-{{$product->id}}" type="submit" class="btn {{ $customisation->button_style ?? '' }} btn-primary me-2 mb-2">
                           Add to Cart
                        </button>
                        {{--                        <a href="{{ url($page?->slug) }}" class="btn {{ $customisation->button_style ?? '' }} btn-secondary me-2 mb-2">Back To {{ $page->title }}</a>--}}
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>

      <div @class([
                   $customisation->section_width_style ?? 'container',
                   'w__' . ($customisation->section_width ?? '100'), 'mt-5'
                ])
      >
         @if($otherProducts->count() > 0)
         <div class="row">
            <h4 class="mb-3">Related Products</h4>

            <div class="other-products-slider">
               @foreach($otherProducts->take(15) as $product)
                  <div class="tiny-slide">
                     <div class="col-12">
                        <div class="card shop-list border-0">
                           <div class="shop-image position-relative overflow-hidden shadow">
                              <a href="{{ route('ecm.products.show', $product->slug) }}">
                                 <img src="{{ $product->media[0]->original_url ?? asset('website/dummy_450x450.jpg') }}" class="img-fluid product-image" alt="{{ $product->slug }}">
                              </a>
                              <a href="{{ route('ecm.products.show', $product->slug) }}" class="overlay-work">
                                 <img src="{{ $product->media[1]->original_url ?? asset('website/dummy_450x450.jpg') }}" class="img-fluid" alt="{{ $product->slug }}">
                              </a>
                           </div>
                           <div class="card-body content pt-4 p-2">
                              <div class="row align-middle">
                                 <div class="col-10">
                                    <a href="{{ route('ecm.products.show', $product->slug) }}" class="text-dark product-name h6">
                                       {{ $product->name }}
                                    </a>
                                    <div class="d-flex justify-content-between mt-1">
                                       <p class="text-success fs-6 mb-0">{{ $product->shop->currency->iso . ' ' . number_format(($product->base_price * 0.01), 0, 2) }}</p>
                                    </div>
                                    <div class="col-2">
                                       <div class="float-end">
                                          <form id="addToCartForm-{{ $product->id }}" class="add-to-cart-form" method="POST" action="{{ route('cart.add') }}">
                                             @csrf
                                             <input type="hidden" name="product_id" value="{{ $product->id }}">
                                             <input type="hidden" name="product_option_id" id="selected_option">
                                             <input type="hidden" name="quantity" id="selected_quantity" value="1">
                                             <input type="hidden" name="base_price" value="{{ $product->base_price }}">
                                             <input type="hidden" name="option_adjusted_price" id="adjusted_price" value="0">
                                             <input type="hidden" name="total_price" id="total_price" value="{{ $product->base_price }}">

                                             <div class="mt-3">
                                                <button id="submit-cart-{{$product->id}}" type="submit" class="btn {{ $customisation->button_style ?? '' }} btn-primary btn-icon btn-sm py-2 px-1">
                                                   <i class="uil uil-shopping-cart-alt"></i>
                                                </button>
                                             </div>
                                          </form>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               @endforeach
            </div>
         @endif
      </div>
   </section>

@endsection

@push('scripts')
   <script>
      document.addEventListener("DOMContentLoaded", function() {
         if(document.querySelector('.tiny-single-item')) {
            tns({
               container: '.tiny-single-item',
               items: 1,
               controls: true,
               mouseDrag: true,
               loop: true,
               rewind: true,
               autoplay: true,
               autoplayButtonOutput: false,
               autoplayTimeout: 3000,
               navPosition: "bottom",
               controlsText: [
                  '<i class="mdi mdi-chevron-left"></i>',
                  '<i class="mdi mdi-chevron-right"></i>'
               ],
               nav: false,
               speed: 400,
               gutter: 0,
            });
         }
      });
      document.addEventListener("DOMContentLoaded", function() {
         if(document.querySelector('.other-products-slider')) {
            tns({
               container: '.other-products-slider',
               controls: false,
               mouseDrag: true,
               loop: true,
               rewind: true,
               autoplay: true,
               autoplayButtonOutput: false,
               autoplayTimeout: 3000,
               navPosition: "bottom",
               speed: 400,
               gutter: 12,
               nav: true,
               controlsText: [
                  '<i class="mdi mdi-chevron-left"></i>',
                  '<i class="mdi mdi-chevron-right"></i>'
               ],
               responsive: {
                  992: {
                     items: 5
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
