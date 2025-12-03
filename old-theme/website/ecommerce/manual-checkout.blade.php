@extends('website.index')

@push('meta_tags')
   {!! SEOTools::generate() !!}
@endpush

@section('content')
   @include('website.shared.page-banner', ['title' => 'Checkout'])

   <section class="section">
      <div @class([
             $customisation->section_width_style ?? 'container',
             'w__' . ($customisation->section_width ?? '100')
          ])
      >
         <div class="row">
            <div class="col-lg-7">
               <form id="manual-checkout-form" action="{{ route('checkout.manual.process') }}" method="POST">
                  @csrf
                  <div class="card shadow rounded border-0">
                     <div class="card-body">
                        <h5 class="card-title mb-0">Customer Information</h5>
                        <p class="text-muted">We'll use the information to send you details and updates about your order.</p>

                        <div class="mb-3">
                           <label for="customer_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                           <input type="text" class="form-control" id="customer_name" name="customer_name" required
                                  placeholder="Enter your full name" value="{{ old('customer_name') }}">
                        </div>

                        <div class="mb-3">
                           <label for="customer_email" class="form-label">Email Address</label>
                           <input type="email" class="form-control" id="customer_email" name="customer_email"
                                  placeholder="your.email@example.com" value="{{ old('customer_email') }}">
                           <small class="text-muted">Optional - for order confirmation</small>
                        </div>

                        <div class="alert alert-info rounded-0 mb-3">
                           <i class="uil uil-info-circle"></i>
                           <strong>How to Pay with M-Pesa Paybill:</strong>
                           <ul class="mb-0 mt-2">
                              <li>Go to <strong>M-Pesa</strong> on your phone.</li>
                              <li>Select <strong>Lipa na M-Pesa</strong>.</li>
                              <li>Select <strong>Paybill</strong>.</li>
                              <li>Enter Business Number: <strong>880100</strong></li>
                              <li>Enter Account Number: <strong>8430340014</strong></li>
                              <li>Enter the Amount: <strong>{{ \App\Helpers\CartHelper::formatPrice($cart->grand_total) }}</strong></li>
                              <li>Enter your M-Pesa PIN and confirm.</li>
                              <li>After payment, enter the M-Pesa Transaction Code below to confirm your payment.</li>
                           </ul>
                        </div>

                        <div class="mb-3">
                           <label for="mpesa_reference_no" class="form-label">M-Pesa Transaction Code <span class="text-danger">*</span></label>
                           <input type="text" class="form-control text-uppercase" id="mpesa_reference_no"
                                  name="mpesa_reference_no" required minlength="10" maxlength="20"
                                  placeholder="e.g. QFT3K1XXXX" value="{{ old('mpesa_reference_no') }}">
                           <small class="text-muted">Enter the M-Pesa confirmation code you received via SMS</small>
                        </div>
                     </div>
                  </div>

                  <div class="card shadow rounded border-0 mt-4">
                     <div class="card-body">
                        <h5 class="card-title mb-0">Shipping Information</h5>
                        <p class="text-muted">Enter the address where you want your order delivered.</p>

                        <div class="row">
                           <div class="col-12">
                              <div class="mb-3">
                                 <input type="text" class="form-control" id="shipping_country"
                                        name="shipping_country" required placeholder="Country / Region"
                                        value="{{ old('shipping_country', 'Kenya') }}">
                              </div>
                           </div>
                           <div class="col-md-6 col-12">
                              <div class="mb-3">
                                 <input type="text" class="form-control" id="shipping_first_name"
                                        name="shipping_first_name" required placeholder="First Name"
                                        value="{{ old('shipping_first_name') }}">
                              </div>
                           </div>
                           <div class="col-md-6 col-12">
                              <div class="mb-3">
                                 <input type="text" class="form-control" id="shipping_last_name"
                                        name="shipping_last_name" required placeholder="Last Name"
                                        value="{{ old('shipping_last_name') }}">
                              </div>
                           </div>
                           <div class="col-12">
                              <div class="mb-3">
                                 <input type="text" class="form-control" id="shipping_street_address"
                                        name="shipping_street_address" required placeholder="Street Address"
                                        value="{{ old('shipping_street_address') }}">
                              </div>
                           </div>
                           <div class="col-md-6 col-12">
                              <div class="mb-3">
                                 <input type="text" class="form-control" id="shipping_state"
                                        name="shipping_state" required placeholder="State / County"
                                        value="{{ old('shipping_state') }}">
                              </div>
                           </div>
                           <div class="col-md-6 col-12">
                              <div class="mb-3">
                                 <input type="text" class="form-control" id="shipping_city"
                                        name="shipping_city" required placeholder="Town / City"
                                        value="{{ old('shipping_city') }}">
                              </div>
                           </div>
                           <div class="col-md-6 col-12">
                              <div class="mb-3">
                                 <input type="text" class="form-control" id="shipping_postal_code"
                                        name="shipping_postal_code" placeholder="Postal Code (optional)"
                                        value="{{ old('shipping_postal_code') }}">
                              </div>
                           </div>
                           <div class="col-12">
                              <div class="mb-3">
                                 <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1"
                                           id="is_billing" name="is_billing"
                                       {{ old('is_billing') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_billing">
                                       Use same billing address
                                    </label>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

                  <button type="submit" class="btn btn-primary w-100 mt-5">
                     Place Your Order
                  </button>
               </form>
            </div>

            <div class="col-lg-5 mt-4 mt-lg-0">
               <div class="sidebar sticky-bar">
                  <div class="card shadow rounded border-0">
                     <div class="card-body">
                        <h5 class="card-title mb-4">Order Summary</h5>

                        <div class="order-items mb-3" style="max-height: 300px; overflow-y: auto;">
                           @foreach($cartItems as $item)
                              <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                 <img src="{{ $item->product->media->where('collection_name', 'product_images')->first()->original_url ?? asset('website/dummy_450x450.jpg') }}"
                                      alt="{{ $item->product->name }}"
                                      class="img-fluid rounded"
                                      style="width: 60px; height: 60px; object-fit: cover;">
                                 <div class="ms-3 flex-grow-1">
                                    <p class="mb-0">{{ $item->product->name }}</p>
                                    @if($item->variant)
                                       <small class="text-muted">{{ $item->variant->name }}</small>
                                    @endif
                                    <div class="text-muted small mt-1">Qty: {{ $item->quantity }}</div>
                                 </div>
                                 <div class="text-end">
                                    <strong>{{ \App\Helpers\CartHelper::formatPrice($item->line_total) }}</strong>
                                 </div>
                              </div>
                           @endforeach
                        </div>

                        <div class="border-top pt-3">
                           <div class="d-flex justify-content-between mb-2">
                              <span>Subtotal:</span>
                              <span>{{ \App\Helpers\CartHelper::formatPrice($cart->sub_total) }}</span>
                           </div>

                           @if($cart->tax_amount > 0)
                              <div class="d-flex justify-content-between mb-2">
                                 <span>Tax:</span>
                                 <span>{{ \App\Helpers\CartHelper::formatPrice($cart->tax_amount) }}</span>
                              </div>
                           @endif

                           @if($cart->discount_amount > 0)
                              <div class="d-flex justify-content-between mb-2 text-success">
                                 <span>Discount:</span>
                                 <span>-{{ \App\Helpers\CartHelper::formatPrice($cart->discount_amount) }}</span>
                              </div>
                           @endif

                           <hr>

                           <div class="d-flex justify-content-between fw-bold mb-0">
                              <span>Total:</span>
                              <span>{{ \App\Helpers\CartHelper::formatPrice($cart->grand_total) }}</span>
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="mt-3">
                     <a href="{{ route('cart.show') }}" class="btn btn-outline-secondary w-100">
                        <i class="uil uil-arrow-left me-2"></i>Back to Cart
                     </a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection

@push('scripts')
   <script src="{{ asset('website/js/checkout-manager.js') }}"></script>
@endpush
