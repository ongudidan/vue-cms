<div class="modal" id="availabilityCheckModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-0">
         <div class="modal-body text-center p-5">
            <!-- Loading State -->
            <div id="checkingState">
               <div class="mb-4">
                  <div class="spinner-border text-primary" style="width: 4rem; height: 4rem;" role="status">
                     <span class="visually-hidden">Loading...</span>
                  </div>
               </div>
               <h5 class="mb-3">Checking Availability...</h5>
               <p class="text-muted">
                  Please wait while we search for available spaces that match your requirements.
               </p>
            </div>

            <!-- No Availability State -->
            <div id="noAvailabilityState" class="d-none">
               <div class="mb-4">
                  <div class="rounded-circle bg-danger bg-opacity-10 d-inline-flex align-items-center justify-content-center"
                       style="width: 80px; height: 80px;">
                     <i class="bi bi-calendar-x text-danger" style="font-size: 2.5rem;"></i>
                  </div>
               </div>
               <h5 class="mb-3">No Availability</h5>
               <p class="text-muted mb-4" id="noAvailabilityMessage"></p>
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                  Try Different Date
               </button>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="modal" id="availableSpacesModal" tabindex="-1" data-bs-backdrop="static">
   <div class="modal-dialog modal-xl modal-dialog-scrollable">
      <div class="modal-content rounded-0">
         <div class="modal-header">
            <div>
               <h5 class="modal-title mb-1">Available Spaces</h5>
               <small class="text-muted" id="availabilitySubtitle"></small>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
         </div>
         <div class="modal-body">
            <div id="availableSpacesContainer" class="row g-4">
               <!-- Will be populated dynamically -->
            </div>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="bookingConfirmationModal" tabindex="-1" data-bs-backdrop="static">
   <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content rounded-0">
         <div class="modal-header border-0">
            <h5 class="modal-title">Confirm Your Booking</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
         </div>
         <div class="modal-body p-4">
            <!-- Booking Summary -->
            <div class="card bg-light border-0 mb-4">
               <div class="card-body">
                  <h6 class="mb-3">Booking Summary</h6>
                  <div id="bookingSummaryContent">
                     <!-- Will be populated dynamically -->
                  </div>
               </div>
            </div>

            <!-- Payment Form -->
            <form id="paymentForm">
               <h6 class="mb-3">Payment Information</h6>

               <div class="alert alert-info">
                  <i class="bi bi-info-circle me-2"></i>
                  <strong>Deposit Required:</strong> <span id="depositAmount"></span>
               </div>

               <div class="mb-3">
                  <label class="form-label">Full Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="paymentName" required>
               </div>

               <div class="mb-3">
                  <label class="form-label">M-Pesa Phone Number <span class="text-danger">*</span></label>
                  <input type="tel" class="form-control" id="paymentPhone"
                         placeholder="254712345678" required>
                  <small class="text-muted">Payment prompt will be sent to this number</small>
               </div>

               <div class="form-check mb-4">
                  <input class="form-check-input" type="checkbox" id="acceptTerms" required>
                  <label class="form-check-label" for="acceptTerms">
                     I agree to the <a href="#" target="_blank">terms and conditions</a>
                  </label>
               </div>

               <div class="d-grid gap-2">
                  <button type="submit" class="btn btn-success btn-lg rounded-0" id="proceedPaymentBtn">
                     <i class="bi bi-credit-card me-2"></i>Proceed to Payment
                  </button>
                  <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">
                     Cancel
                  </button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="paymentProcessingModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-0">
         <div class="modal-body text-center p-5">
            <div class="mb-4">
               <div class="spinner-border text-success" style="width: 4rem; height: 4rem;" role="status">
                  <span class="visually-hidden">Processing...</span>
               </div>
            </div>
            <h5 class="mb-3">Processing Payment...</h5>
            <p class="text-muted mb-4">
               Please check your phone for the M-Pesa payment prompt.<br>
               Enter your M-Pesa PIN to complete the payment.
            </p>
            <div class="alert alert-info">
               <strong>Booking Number:</strong> <span id="processingBookingNumber"></span>
            </div>
            <p class="small text-muted">
               Do not close this window. This may take a few moments.
            </p>
         </div>
      </div>
   </div>
</div>

@push('booking-js')
   <script src="{{ asset('website/js/restaurant-booking.js') }}"></script>
@endpush
