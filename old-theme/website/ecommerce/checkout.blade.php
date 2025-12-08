{{-- resources/views/checkout/index.blade.php --}}
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
               <div class="card shadow rounded border-0">
                  <div class="card-body">
                     <h5 class="card-title mb-0">Customer Information</h5>
                     <p class="text-muted">We'll use the information to send you details and updates about your order.</p>

                     <form id="checkoutForm">
                        @csrf

                        <div class="mb-3">
                           <label for="customer_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                           <input type="text" class="form-control" id="customer_name" name="customer_name" required
                                  placeholder="Enter your full name">
                        </div>

                        <div class="mb-3">
                           <label for="customer_email" class="form-label">Email Address</label>
                           <input type="email" class="form-control" id="customer_email" name="customer_email"
                                  placeholder="your.email@example.com">
                           <small class="text-muted">Optional - for order confirmation</small>
                        </div>

                        <div class="mb-4">
                           <label for="phone_number" class="form-label">M-Pesa Phone Number <span class="text-danger">*</span></label>
                           <input type="tel" class="form-control" id="phone_number" name="phone_number" required
                                  placeholder="0712345678 or 254712345678" pattern="^(254|0)[17]\d{8}$">
                           <small class="text-muted">Enter Safaricom number for M-Pesa payment</small>
                        </div>

                        <div class="alert alert-info">
                           <i class="uil uil-info-circle"></i>
                           <strong>Payment Instructions:</strong>
                           <ul class="mb-0 mt-2">
                              <li>Click "Pay with M-Pesa" button below</li>
                              <li>Enter your M-Pesa PIN on your phone</li>
                              <li>Confirm the payment</li>
                              <li>Wait for confirmation</li>
                           </ul>
                        </div>

                        <button type="submit"
                                class="btn btn-primary w-100"
                                id="payButton">
                           <i class="uil uil-mobile-android me-2"></i>Pay with M-Pesa
                        </button>
                     </form>
                  </div>
               </div>
            </div>

            <div class="col-lg-5 mt-4 mt-lg-0">
               <div class="card shadow rounded border-0 sidebar sticky-bar">
                  <div class="card-body">
                     <h6 class="card-title mb-4">Order Summary</h6>

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
   </section>

   {{-- Payment Processing Modal --}}
   <div class="modal fade" id="paymentModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-body text-center py-5">
               <div class="payment-status" id="paymentPending">
                  <div class="spinner-border text-primary mb-3" style="width: 4rem; height: 4rem;" role="status">
                     <span class="visually-hidden">Loading...</span>
                  </div>
                  <h5>Processing Payment...</h5>
                  <p class="text-muted">
                     Please check your phone and enter your M-Pesa PIN to complete the payment.
                  </p>
                  <div class="alert alert-warning mt-3">
                     <i class="uil uil-exclamation-triangle"></i>
                     Don't close this window or refresh the page
                  </div>
               </div>

               <div class="payment-status d-none" id="paymentSuccess">
                  <div class="mb-3">
                     <i class="uil uil-check-circle text-success" style="font-size: 5rem;"></i>
                  </div>
                  <h5 class="text-success">Payment Successful!</h5>
                  <p class="text-muted">Your order has been placed successfully.</p>
                  <a href="{{ route('home') }}" class="btn btn-primary mt-3">Continue Shopping</a>
               </div>

               <div class="payment-status d-none" id="paymentFailed">
                  <div class="mb-3">
                     <i class="uil uil-times-circle text-danger" style="font-size: 5rem;"></i>
                  </div>
                  <h5 class="text-danger">Payment Failed</h5>
                  <p class="text-muted" id="paymentErrorMessage">Something went wrong. Please try again.</p>
                  <button type="button" class="btn btn-secondary mt-3" data-bs-dismiss="modal">Close</button>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection

@push('scripts')
   <script>
      document.addEventListener('DOMContentLoaded', function() {
         const checkoutForm = document.getElementById('checkoutForm');
         const payButton = document.getElementById('payButton');
         const paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
         let checkoutRequestId = null;
         let statusCheckInterval = null;

         checkoutForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            // Validate form
            if (!checkoutForm.checkValidity()) {
               checkoutForm.classList.add('was-validated');
               return;
            }

            // Disable button
            payButton.disabled = true;
            payButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';

            try {
               const formData = new FormData(checkoutForm);

               const response = await fetch('{{ route("checkout.process") }}', {
                  method: 'POST',
                  headers: {
                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                     'Accept': 'application/json'
                  },
                  body: formData
               });

               const data = await response.json();

               if (data.success) {
                  checkoutRequestId = data.checkout_request_id;

                  // Show payment modal
                  showPaymentStatus('pending');
                  paymentModal.show();

                  // Start checking payment status
                  startPaymentStatusCheck();
               } else {
                  toastr.error(data.message || 'Failed to initiate payment', 'Error');
                  resetPayButton();
               }

            } catch (error) {
               console.error('Checkout error:', error);
               toastr.error('An error occurred. Please try again.', 'Error');
               resetPayButton();
            }
         });

         function startPaymentStatusCheck() {
            let attempts = 0;
            const maxAttempts = 60; // Check for 2 minutes (60 * 2 seconds)

            statusCheckInterval = setInterval(async () => {
               attempts++;

               if (attempts > maxAttempts) {
                  clearInterval(statusCheckInterval);
                  showPaymentStatus('failed');
                  document.getElementById('paymentErrorMessage').textContent =
                     'Payment timeout. Please try again or contact support.';
                  return;
               }

               try {
                  const response = await fetch('{{ route("checkout.check-status") }}', {
                     method: 'POST',
                     headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                     },
                     body: JSON.stringify({ checkout_request_id: checkoutRequestId })
                  });

                  const data = await response.json();

                  if (data.status === 'completed') {
                     clearInterval(statusCheckInterval);
                     showPaymentStatus('success');

                     // Redirect to success page after 3 seconds
                     setTimeout(() => {
                        window.location.href = '{{ route("home") }}';
                     }, 3000);
                  } else if (data.status === 'cancelled' || data.status === 'failed') {
                     clearInterval(statusCheckInterval);
                     showPaymentStatus('failed');
                     document.getElementById('paymentErrorMessage').textContent = data.message;
                  }
               } catch (error) {
                  console.error('Status check error:', error);
               }
            }, 2000); // Check every 2 seconds
         }

         function showPaymentStatus(status) {
            document.getElementById('paymentPending').classList.add('d-none');
            document.getElementById('paymentSuccess').classList.add('d-none');
            document.getElementById('paymentFailed').classList.add('d-none');

            if (status === 'pending') {
               document.getElementById('paymentPending').classList.remove('d-none');
            } else if (status === 'success') {
               document.getElementById('paymentSuccess').classList.remove('d-none');
            } else if (status === 'failed') {
               document.getElementById('paymentFailed').classList.remove('d-none');
               resetPayButton();
            }
         }

         function resetPayButton() {
            payButton.disabled = false;
            payButton.innerHTML = '<i class="uil uil-mobile-android me-2"></i>Pay with M-Pesa';
         }

         // Clear interval if modal is closed manually
         document.getElementById('paymentModal').addEventListener('hidden.bs.modal', function() {
            if (statusCheckInterval) {
               clearInterval(statusCheckInterval);
            }
            resetPayButton();
         });
      });
   </script>
@endpush
