@php
   $backgroundImage = $section->media?->firstWhere('collection_name', 'section_bg');
   $sectionImage = $section->media?->firstWhere('collection_name', 'section_image');
@endphp
<section class="section">
   @if($section->section_has_bg)
      <div class="{{ $section->section_background_color ?? 'bg-overlay ' }}">
         @if($section->section_background_type === 'image-bg')
         <img src="{{ $backgroundImage->getUrl() ?? asset('website/images/backgrounds/T5.jpg') }}" alt="">
         @endif
      </div>
   @endif
      <div @class([
             $customisation->section_width_style ?? 'container',
             'w__' . ($customisation->section_width ?? '100')
          ]) id="portfolio"
      >
      <div class="row">
         @if($section->sub_title || $section->title || $section->details)
         <div class="col-12">
            <div class="mb-4 text-center">
               @if($section->sub_title)
               <p class="sub-title" data-aos="fade-up" data-aos-duration="1800" data-aos-delay="100">
                  {{ $section->sub_title }}
               </p>
               @endif
               @if($section->title)
               <h3 class="title" data-aos="fade-up" data-aos-duration="1800" data-aos-delay="200">
                  {{ $section->title }}
               </h3>
               @endif
               @if($section->details)
               <div class="text-muted details" data-aos="fade-up" data-aos-duration="1800" data-aos-delay="350">
                  {!! $section->details !!}
               </div>
               @endif
            </div>
         </div>
         @endif

         @if($section->type === 'section-ecommerce-product-category' && $section->section_style)
            @include('website.designs.' . $section->section_style, ['section' => $section, 'customisation' => $customisation])
         @else
         <div class="col-12 mt-4 ps-2" data-aos="fade-up" data-aos-duration="1800" data-aos-delay="200">
            <div class="row">
               @foreach($ecmProducts->filter(fn($product) =>
                   $product->categories->contains('id', $section->section_link->linkable->id)
               )->take(20) as $key => $product)
                  <div class="col-md-3 col-12">
                     <div class="card shop-list border-0 mb-3">
                        <div class="shop-image position-relative overflow-hidden shadow">
                           <a href="{{ route('ecm.products.show', $product->slug) }}">
                              <img src="{{ $product->media[0]->original_url ?? asset('website/dummy_1266x749.jpg.jpg') }}" class="img-fluid rounded product-image" alt="{{ $product->slug }}">
                           </a>
                           <a href="{{ route('ecm.products.show', $product->slug) }}" class="overlay-work">
                              <img src="{{ $product->media[1]->original_url ?? asset('website/dummy_450x450.jpg') }}" class="img-fluid rounded" alt="{{ $product->slug }}">
                           </a>
{{--                              <div class="overlay-work">--}}
{{--                                 <div class="py-2 bg-gray rounded-bottom out-stock">--}}
{{--                                    <h6 class="mb-0 text-center text-dark">Out of stock</h6>--}}
{{--                                 </div>--}}
{{--                              </div>--}}

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
                                       <button id="submit-cart-{{$product->id}}" type="submit" class="btn {{ $customisation->button_style ?? '' }} btn-primary btn-sm">
                                          <i class="uil uil-shopping-cart-alt"></i>
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
                           <div class="d-flex text-center mt-1">
                              <div class="text-muted details">{!! Str::words($product->description, 25) !!}</div>
                           </div>
                        </div>
                     </div>
                  </div>
               @endforeach
            </div>
         </div>
         @endif
      </div>
   </div>
</section>
