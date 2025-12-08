@extends('website.index')
@push('meta_tags')
   {!! SEOTools::generate() !!}
@endpush
@section('content')
   @include('website.shared.page-banner', ['title' => 'Cart'])
   <section class="section">
      <div @class([
             $customisation->section_width_style ?? 'container',
             'w__' . ($customisation->section_width ?? '100'), 'cart'
          ])
      >
         <div class="row">
            <div class="col-12">
               @if($cartItems && $cartItems->count() > 0)
                  <div class="table-responsive bg-white shadow rounded mb-3">
                     <table class="table mb-0 table-center">
                        <thead>
                        <tr>
                           <th class="border-bottom fw-medium py-3" style="min-width:20px "></th>
                           <th class="border-bottom fw-medium text-start py-3" style="min-width: 300px;">Product</th>
                           <th class="border-bottom fw-medium text-center py-3" style="min-width: 160px;">Price</th>
                           <th class="border-bottom fw-medium text-center py-3" style="min-width: 160px;">Qty</th>
                           <th class="border-bottom fw-medium text-end py-3 pe-4" style="min-width: 160px;">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cartItems as $item)
                           <tr data-cart-item="{{ $item->id }}" class="text-center align-items-center">
                              <td class="h4 text-center align-middle">
                                 <a href="#" class="text-danger remove-cart-item" data-item-id="{{ $item->id }}">
                                    <i class="uil uil-trash-alt"></i>
                                 </a>
                              </td>
                              <td>
                                 <div class="align-middle">
                                    <div class="d-flex align-items-center">
                                       <img src="{{$item->product->media->where('collection_name', 'product_images')->first()->original_url ?? asset('dummy-image.jpg')}}"
                                            class="img-fluid avatar avatar-small rounded shadow" style="height:auto;" alt="{{ $item->product->slug }}">
                                       <p class="mb-0 ms-3">
                                          {{ $item->product->name }}
                                          @if($item->product_variant_option_id)
                                             <span class="text-muted">({{$item->variant?->name ?? ''}})</span>
                                          @endif
                                       </p>
                                    </div>
                                 </div>
                              </td>
                              <td class="align-middle text-center">
                                 {{ \App\Helpers\CartHelper::formatPrice($item->base_price) }}
                                 @if($item->product_variant_option_id)
                                    <span class="text-muted small"> + {{ number_format(($item->variant->price_adjustment * 0.01), 0, 2) }}</span>
                                 @endif
                              </td>
                              <td class="align-middle text-center qty-icons">
                                 <div class="qty-controls d-flex align-items-center">
                                    <button type="button" class="btn btn-sm btn-outline-secondary cart-qty-update" data-item-id="{{ $item->id }}" data-action="decrease">
                                       <i class="uil uil-minus"></i>
                                    </button>
                                    <input type="number" class="form-control mx-2 text-center cart-qty-input"
                                           style="width: 70px;" value="{{ $item->quantity }}" min="1" data-item-id="{{ $item->id }}">
                                    <button type="button" class="btn btn-sm btn-outline-secondary cart-qty-update" data-item-id="{{ $item->id }}" data-action="increase">
                                       <i class="uil uil-plus"></i>
                                    </button>
                                 </div>
                              </td>
                              <td class="align-middle text-end fw-medium pe-4">{{ \App\Helpers\CartHelper::formatPrice($item->line_total) }}</td>
                           </tr>
                        @endforeach
                        </tbody>
                     </table>
                  </div>
                  <div class="row">
                     {{--                  <div class="col-lg-8 col-md-6 mt-4 pt-2">--}}
                     {{--                     <a href="javascript:void(0)" class="btn btn-primary">Shop More</a>--}}
                     {{--                     <a href="javascript:void(0)" class="btn btn-soft-primary ms-2">Update Cart</a>--}}
                     {{--                  </div>--}}
                     <div class="col-lg-4 col-md-6 ms-auto pt-2">
                        <div class="table-responsive bg-white rounded shadow">
                           <table class="table table-center table-padding mb-0">
                              <tbody>
                              <tr>
                                 <td class="ps-4 py-3">Subtotal</td>
                                 <td class="text-end fw-medium pe-4 cart-subtotal">{{ \App\Helpers\CartHelper::formatPrice($cart->sub_total) }}</td>
                              </tr>
                              @if($cart->tax_amount > 0)
                                 <tr>
                                    <td class="ps-4 py-3">Tax</td>
                                    <td class="text-end fw-medium pe-4">{{ \App\Helpers\CartHelper::formatPrice($cart->tax_amount) }}</td>
                                 </tr>
                              @endif
                              @if($cart->discount_amount > 0)
                                 <tr>
                                    <td class="ps-4 py-3">Discount</td>
                                    <td class="text-end fw-medium pe-4">{{ \App\Helpers\CartHelper::formatPrice($cart->tax_amount) }}</td>
                                 </tr>
                              @endif
                              <tr class="bg-light">
                                 <td class="fw-semibold ps-4 py-3">Total</td>
                                 <td class="text-end fw-semibold pe-4 cart-total">{{ \App\Helpers\CartHelper::formatPrice($cart->grand_total) }}</td>
                              </tr>
                              </tbody>
                           </table>
                        </div>
                        <div class="mt-4 text-end">
                           <a href="{{ route('checkout') }}" class="btn {{ $customisation->button_style ?? '' }}">Proceed to checkout</a>
                        </div>
                     </div>
                  </div>
               @else
                  <div class="empty-cart text-center py-5">
                     <div class="mb-4">
                        <i class="uil uil-shopping-cart-alt" style="font-size: 4rem; color: #adb5bd;"></i>
                     </div>
                     <h4>Your cart is empty</h4>
                     <p class="text-muted">Add some products to get started!</p>
                  </div>
               @endif
            </div>
         </div>
      </div>
   </section>
@endsection
