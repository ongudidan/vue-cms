@extends('website.index')

@push('meta_tags')
   {!! SEOTools::generate() !!}
@endpush

@section('content')
   @include('website.shared.page-banner', ['title' => 'Order Details'])
   <section class="section">
      <div @class([
             $customisation->section_width_style ?? 'container',
             'w__' . ($customisation->section_width ?? '100')
          ])
      >
         <div class="row">
            <div class="col-lg-7">
               <div class="card shadow rounded border-0 mb-4">
                  <div class="card-body text-center py-5">
                     <div class="mb-4">
                        <i class="uil uil-check-circle text-success" style="font-size: 5rem;"></i>
                     </div>
                     <h4 class="mb-3">Order Placed Successfully!</h4>
                     <p class="text-muted mb-4">
                        Thank you for your order. We have received your payment details and will verify them shortly.
                     </p>

                     @if($order->payment_status === \App\Models\Ecommerce\EcmOrder::PAYMENT_PENDING)
                        <div class="alert alert-warning mt-3 rounded-0 text-start">
                           <strong>Payment Verification:</strong> Your payment is pending verification.
                           We will confirm your M-Pesa transaction and process your order within 24 hours.
                        </div>
                     @endif

                     {{--                     @if($order->customer_email)--}}
                     {{--                        <p class="text-muted mb-0">--}}
                     {{--                           <i class="uil uil-envelope"></i>--}}
                     {{--                           A confirmation email has been sent to <strong>{{ $order->customer_email }}</strong>--}}
                     {{--                        </p>--}}
                     {{--                     @endif--}}
                  </div>
               </div>

               <div class="card shadow rounded border-0 mb-4">
                  <div class="card-body">
                     <h5 class="card-title border-bottom pb-3 mb-4">Order Details</h5>

                     <div class="row mb-2">
                        <div class="col-6">
                           <p class="text-muted mb-1">Order Number</p>
                           <p class="fw-bold">{{ $order->code }}</p>
                        </div>
                        <div class="col-6 text-end">
                           <p class="text-muted mb-1">Order Date</p>
                           <p class="fw-bold">{{ \Carbon\Carbon::parse($order->placed_at)->format('M d, Y') }}</p>
                        </div>
                     </div>

                     <div class="row mb-2">
                        <div class="col-6">
                           <p class="text-muted mb-1">Order Status</p>
                           <span class="{{ $order->status_badge_class }}">{{ $order->status_text }}</span>
                        </div>
                        <div class="col-6 text-end">
                           <p class="text-muted mb-1">Payment Status</p>
                           <span class="{{ $order->payment_status_badge_class }}">{{ $order->payment_status_text }}</span>
                        </div>
                     </div>

                     @if($order->payment->isNotEmpty())
                        <div class="row">
                           <div class="col-12">
                              <p class="text-muted mb-1">M-Pesa Reference</p>
                              <p class="fw-bold">{{ $order->payment->first()->reference_number }}</p>
                           </div>
                        </div>
                     @endif
                  </div>
               </div>

               @if($order->shippingAddress)
                  <div class="card shadow rounded border-0 mb-4">
                     <div class="card-body">
                        <h4 class="card-title border-bottom pb-3 mb-4">Shipping Address</h4>

                        <p class="mb-1"><span class="fw-bold">Name:</span> {{ $order->shippingAddress->full_name }}</p>
                        <p class="mb-1"><span class="fw-bold">Address:</span> {{ $order->shippingAddress->line1 }}</p>
                        <p class="mb-1"><span class="fw-bold">Location:</span> {{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }}</p>
                        @if($order->shippingAddress->postal_code)
                           <p class="mb-1"><span class="fw-bold">Postal Code:</span> {{ $order->shippingAddress->postal_code }}</p>
                        @endif
                        <p class="mb-0"><span class="fw-bold">Country:</span> {{ $order->shippingAddress->country }}</p>
                     </div>
                  </div>
               @endif

               <div class="text-start">
                  <a href="{{ route('home') }}" class="btn btn-primary">
                     Continue Shopping
                  </a>
               </div>
            </div>

            <div class="col-lg-5 mt-4 mt-lg-0">
               <div class="sidebar sticky-bar">
                  <div class="card shadow rounded border-0 mb-4">
                     <div class="card-body">
                        <h5 class="card-title border-bottom pb-3 mb-4">Order Items</h5>

                        @foreach($order->details as $item)
                           <div class="d-flex align-items-center mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                              <img src="{{ $item->product->media->where('collection_name', 'product_images')->first()->original_url ?? asset('website/dummy_450x450.jpg') }}"
                                   alt="{{ $item->product->name }}"
                                   class="img-fluid rounded"
                                   style="width: 80px; height: 80px; object-fit: cover;">
                              <div class="ms-3 flex-grow-1">
                                 <h4 class="mb-1">{{ $item->product->name }}</h4>
                                 @if($item->variant)
                                    <small class="text-muted">{{ $item->variant->name }}</small>
                                 @endif
                                 <div class="text-muted small mt-1">
                                    Quantity: {{ $item->quantity }} × {{ \App\Helpers\CartHelper::formatPrice($item->base_price) }}
                                 </div>
                              </div>
                              <div class="text-end">
                                 <strong>{{ \App\Helpers\CartHelper::formatPrice($item->line_total) }}</strong>
                              </div>
                           </div>
                        @endforeach

                        <div class="border-top pt-3 mt-3">
                           <div class="d-flex justify-content-between mb-2">
                              <span>Subtotal:</span>
                              <span>{{ \App\Helpers\CartHelper::formatPrice($order->sub_total ?? 0) }}</span>
                           </div>

                           @if($order->tax_amount > 0)
                              <div class="d-flex justify-content-between mb-2">
                                 <span>Tax:</span>
                                 <span>{{ \App\Helpers\CartHelper::formatPrice($order->tax_amount) }}</span>
                              </div>
                           @endif

                           @if($order->discount_amount > 0)
                              <div class="d-flex justify-content-between mb-2 text-success">
                                 <span>Discount:</span>
                                 <span>-{{ \App\Helpers\CartHelper::formatPrice($order->discount_amount) }}</span>
                              </div>
                           @endif

                           <hr>

                           <div class="d-flex justify-content-between fw-bold">
                              <span>Total:</span>
                              <span>{{ \App\Helpers\CartHelper::formatPrice($order->grand_total ?? 0) }}</span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection
