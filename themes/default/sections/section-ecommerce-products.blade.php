@if($section->type === 'section-ecommerce-products' && $section->section_style)
   @include('website.designs.' . $section->section_style, ['section' => $section, 'customisation' => $customisation])
@else
<section class="section">
   <div @class([
             $customisation->section_width_style ?? 'container',
             'w__' . ($customisation->section_width ?? '100')
          ]) id="portfolio"
   >
      <div class="row justify-content-center">
         <div class="col-12">
            <div class="mb-4">
               @if($section->sub_title)
                  <p class="sub-title" data-aos="fade-right" data-aos-duration="1800" data-aos-delay="100">
                     {{ $section->sub_title }}
                  </p>
               @endif
               <h3 class="title" data-aos="fade-right" data-aos-duration="1800" data-aos-delay="200">
                  {{ $section->title ?? '' }}
               </h3>
               <div class="text-muted details" data-aos="fade-right" data-aos-duration="1800" data-aos-delay="350">
                  {!! $section->details !!}
               </div>
            </div>
         </div>
         <div class="col-12">
            <div class="filters-group-wrap text-center">
               <div class="filters-group">
                  <ul class="container-filter mb-0 categories-filter list-unstyled filter-options" data-aos="fade-up" data-aos-duration="1800" data-aos-delay="350">
                     <li class="list-inline-item categories position-relative active" data-group="all">All</li>
                     @foreach($groupedEcmProducts->take(4) as $categoryName => $items)
                        <li class="list-inline-item categories position-relative "
                            data-group="{{ $categoryName }}">
                           {{ $categoryName }}
                        </li>
                     @endforeach
                  </ul>
               </div>
            </div>
         </div>
      </div>
      <div id="grid" class="row row-cols-md-2 row-cols-lg-5" data-aos-duration="1800" data-aos-delay="400">
         @foreach($groupedEcmProducts->take(4) as $categoryName => $products)
         @foreach($products->take(5) as $key => $product)
         <div class="col-lg-3 col-12 spacing picture-item mb-3" data-groups='["{{ $categoryName }}"]'
              data-aos="fade-up">
            <div class="card shop-list border-0">
               <ul class="label list-unstyled mb-0">
                  <li><a href="javascript:void(0)" class="badge text-bg-success rounded-lg">{{ $categoryName }}</a></li>
               </ul>
               <div class="shop-image position-relative overflow-hidden rounded shadow">
                  <a href="{{ route('ecm.products.show', $product->slug) }}">
                     <img src="{{ $product->media[0]->original_url ?? asset('website/dummy_450x450.jpg') }}" class="img-fluid product-image" alt="{{ $product->slug }}">
                  </a>
                  <a href="{{ route('ecm.products.show', $product->slug) }}" class="overlay-work">
                     <img src="{{ $product->media[0]->original_url ?? asset('website/dummy_450x450.jpg') }}" class="img-fluid" alt="{{ $product->slug }}">
                  </a>
               </div>
               <div class="card-body content pt-4 p-2">
                  <div class="row align-middle">
                     <div class="col-10">
                        <a href="{{ route('ecm.products.show', $product->slug) }}" class="text-dark product-name h6">
                           {{ $product->name }}
                        </a>
                        <div class="d-flex justify-content-between mt-1">
                           <h6 class="text-success small font-italic mb-0">{{ $product->shop->currency->iso . ' ' . number_format(($product->base_price * 0.01), 0, 2) }}</h6>
                        </div>
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
{{--                           <a href="javascript:void(0)" class="btn btn-secondary btn-icon btn-sm"><i class="uil uil-shopping-cart-alt"></i></a>--}}
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         @endforeach
         @endforeach
      </div>
   </div>
</section>
@endif
