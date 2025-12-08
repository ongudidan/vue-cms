@extends('website.index')

@push('meta_tags')
   {!! SEOTools::generate() !!}
@endpush

@section('content')
   @include('website.shared.page-banner', ['title' => $page->title])

   <section class="section">
      <div @class([
             $customisation->section_width_style ?? 'container',
             'w__' . ($customisation->section_width ?? '100')
          ])
      >
         <div class="row">
            <div class="col-12">
               <div class="row">
                  <div class="col-lg-9 col-md-9 col-12">
                     <div class="row">
                        @foreach($products as $product)
                           <div class="col-lg-3 col-md-6 col-12 mb-5 pb-2">
                              <div class="card shop-list border-0 rounded">
                                 <div class="shop-image position-relative overflow-hidden shadow">
                                    <a href="{{ route('ecm.products.show', $product->slug) }}">
                                       <img src="{{ $product->media[0]->original_url ?? asset('website/dummy_450x450.jpg') }}" class="img-fluid rounded product-image" alt="{{ $product->slug }}">
                                    </a>
                                    <a href="{{ route('ecm.products.show', $product->slug) }}" class="overlay-work">
                                       <img src="{{ $product->media[1]->original_url ?? asset('website/dummy_450x450.jpg') }}" class="img-fluid rounded" alt="{{ $product->slug }}">
                                    </a>
                                 </div>
                                 <div class="card-body content pt-4 p-2">
                                    <div class="row align-middle d-flex">
                                       <div class="col-10">
                                          <a href="{{ route('ecm.products.show', $product->slug) }}" class="text-dark product-name h6 mb-0">
                                             {{ $product->name }}
                                          </a>
                                          <div class="d-flex justify-content-between">
                                             <p class="text-success fs-6 mb-0">{{ $product->shop->currency->iso . ' ' . number_format(($product->base_price * 0.01), 0, 2) }}</p>
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

                                                <div class="mt-md-0 mt-3">
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
                        @endforeach

                     </div>
                     <div class="col-12 mt-5">
                        {{ $products->links() }}
                     </div>
                  </div>
                  <div class="col-lg-3 col-md-3 col-12 mt-4 mt-sm-0 pt-sm-0">
                     <div class="sidebar sticky-bar">
                        <!-- SEARCH -->
                        <div class="widget">
                           <form action="{{ route('ecm.products.search') }}" method="get">
                              <div class="input-group mb-3 border rounded">
                                 <input type="text" id="s" name="s" class="form-control border-0" placeholder="Search Keywords...">
                                 <button type="submit" class="input-group-text bg-white border-0" id="searchSubmit"><i class="uil uil-search title-dark"></i></button>
                              </div>
                           </form>
                        </div>

                        <div class="widget mt-4 pt-2">
                           <h5 class="widget-title font-weight-bold pt-2 pb-2 bg-light rounded text-center">Categories</h5>
                           <dl class="row mb-0 mt-4">
                              @foreach($ecmCategories as $category)
                                 <dd class="mb-2">
                                    <a href="{{ route('ecm.category.show', $category->slug) }}" class="text-dark">
                                       <i class="uil uil-arrow-right"></i> {{ $category->name }}
                                    </a>
                                 </dd>
                              @endforeach
                           </dl>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection
