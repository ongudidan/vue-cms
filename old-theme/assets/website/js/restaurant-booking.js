document.addEventListener("DOMContentLoaded", function() {
   const showBtn = document.getElementById("showBookingBtn");
   const form = document.getElementById("bookingForm");
   const closeBtn = document.getElementById("closeBookingBtn");

   showBtn.addEventListener("click", function() {
      form.classList.add("show");
      showBtn.style.display = "none";
   });

   closeBtn.addEventListener("click", function() {
      form.classList.remove("show");
      // Wait for the transition to finish before showing the button again
      setTimeout(() => {
         showBtn.style.display = "block";
      }, 400);
   });
});


let bookingData = {
   customer: {},
   selectedSpace: null,
   pricing: null
};

// Form Submission - Check Availability
document.getElementById('quickBookingForm').addEventListener('submit', async function(e) {
   e.preventDefault();

   // Collect form data
   const formData = new FormData(this);
   bookingData.customer = {
      customer_name: formData.get('customer_name'),
      customer_email: formData.get('customer_email'),
      customer_phone: formData.get('customer_phone'),
      guest_count: parseInt(formData.get('guest_count')),
      booking_date: formData.get('booking_date'),
      booking_time: formData.get('booking_time'),
      booking_type: formData.get('booking_type'),
      space_type: formData.get('space_type')
   };

   // Validate date
   const selectedDate = new Date(bookingData.customer.booking_date);
   const today = new Date();
   today.setHours(0, 0, 0, 0);

   if (selectedDate < today) {
      alert('Please select a date from today onwards');
      return;
   }

   // Show availability check modal
   const availabilityModal = new bootstrap.Modal(document.getElementById('availabilityCheckModal'));
   availabilityModal.show();

   // Reset states
   document.getElementById('checkingState').classList.remove('d-none');
   document.getElementById('noAvailabilityState').classList.add('d-none');

   // Check availability
   try {
      const response = await fetch('/api/restaurant/check-availability', {
         method: 'POST',
         headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
         },
         body: JSON.stringify(bookingData.customer)
      });

      const result = await response.json();

      if (result.success && result.available_spaces.length > 0) {
         // Close availability check modal
         availabilityModal.hide();

         // Show available spaces modal
         displayAvailableSpaces(result.available_spaces);
      } else {
         // Show no availability state
         document.getElementById('checkingState').classList.add('d-none');
         document.getElementById('noAvailabilityState').classList.remove('d-none');
         document.getElementById('noAvailabilityMessage').textContent =
            result.message || 'No spaces available for your selected date and time. Please try a different date.';
      }
   } catch (error) {
      console.error('Error:', error);
      alert('An error occurred while checking availability. Please try again.');
      availabilityModal.hide();
   }
});

// Display Available Spaces
function displayAvailableSpaces(spaces) {
   const container = document.getElementById('availableSpacesContainer');
   const subtitle = document.getElementById('availabilitySubtitle');

   subtitle.textContent = `${spaces.length} space(s) available for ${bookingData.customer.guest_count} guests`;

   container.innerHTML = spaces.map(space => `
      <div class="col-md-6 col-12">
         <div class="card h-100 border hover-shadow">
             <div class="card-body">
                 <div class="d-flex justify-content-between align-items-start mb-3">
                     <div>
                         <h5 class="card-title mb-0">${space.name}</h5>
                         <small class="text-muted">${space.type_label}</small>
                     </div>
                     <span class="badge bg-success">Available</span>
                 </div>

                 <div class="card-text text-muted mb-3 details">${space.description || ''}</div>

                 <div class="d-flex gap-3 mb-3">
                     <span class="badge bg-light text-dark align-items-center justify-content-start">
                         <i class="ti ti-users-group fs-3 text-primary"></i> Up to ${space.capacity}
                     </span>
                     ${space.area_sqm ? `
                         <span class="badge bg-light text-dark align-items-center justify-content-start">
                             <i class="ti ti-ruler fs-3 text-primary"></i> ${space.area_sqm}m²
                         </span>
                     ` : ''}
                 </div>

                 ${space.amenities && space.amenities.length > 0 ? `
                     <div class="mb-3">
                         ${space.amenities.slice(0, 7).map(amenity => `
                             <i class="mdi ${amenity.icon || 'mdi mdi-check-circle'} text-primary me-1 fs-2"
                                title="${amenity.name}"></i>
                         `).join('')}
                         ${space.amenities.length > 7 ? `
                             <small class="text-muted">+${space.amenities.length - 4} more</small>
                         ` : ''}
                     </div>
                 ` : ''}

                 <hr>

                 <div class="d-flex justify-content-between align-items-center">
                     <div>
                         <small class="text-muted d-block">
                             ${space.type === 'room' ? 'Booking Deposit' : 'Reservation Fee'}
                         </small>
                         <h5 class="text-primary mb-0">
                             KES ${parseFloat(space.deposit_amount || 0).toLocaleString()}
                         </h5>
                     </div>
                     <button class="btn btn-primary rounded-0" type="button" onclick="selectSpace(${space.id}, '${space.type}')">
                         Select <i class="mdi mdi-arrow-right ms-1"></i>
                     </button>
                 </div>
             </div>
         </div>
     </div>
   `).join('');

   const spacesModal = new bootstrap.Modal(document.getElementById('availableSpacesModal'));
   spacesModal.show();
}

// Select Space and Show Confirmation
async function selectSpace(spaceId, spaceType) {
   // Get space details
   try {
      const response = await fetch(`/api/restaurant/${spaceType}s/${spaceId}`);
      const space = await response.json();

      bookingData.selectedSpace = space;

      // Calculate pricing
      const pricingResponse = await fetch('/api/restaurant/calculate-price', {
         method: 'POST',
         headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
         },
         body: JSON.stringify({
            bookable_type: spaceType,
            bookable_id: spaceId,
            booking_date: bookingData.customer.booking_date,
            booking_time: bookingData.customer.booking_time,
            guest_count: bookingData.customer.guest_count,
            duration: 2 // Default 2 hours
         })
      });

      bookingData.pricing = await pricingResponse.json();

      // Hide spaces modal
      bootstrap.Modal.getInstance(document.getElementById('availableSpacesModal')).hide();

      // Show confirmation modal
      showBookingConfirmation();

   } catch (error) {
      console.error('Error:', error);
      alert('Failed to load space details. Please try again.');
   }
}

// Show Booking Confirmation Modal
function showBookingConfirmation() {
   const space = bookingData.selectedSpace;
   const customer = bookingData.customer;
   const pricing = bookingData.pricing;

   // Populate booking summary
   document.getElementById('bookingSummaryContent').innerHTML = `
         <div class="row g-3">
            <div class="col-6">
                <small class="text-muted">Space</small>
                <div class="fw-semibold">${space.name}</div>
            </div>
            <div class="col-6">
                <small class="text-muted">Date</small>
                <div class="fw-semibold">${new Date(customer.booking_date).toLocaleDateString()}</div>
            </div>
            <div class="col-6">
                <small class="text-muted">Time</small>
                <div class="fw-semibold">${customer.booking_time}</div>
            </div>
            <div class="col-6">
                <small class="text-muted">Guests</small>
                <div class="fw-semibold">${customer.guest_count} people</div>
            </div>
            <div class="col-12"><hr></div>
            <div class="col-12">
                <div class="d-flex justify-content-between mb-2">
                    <span>Base Price:</span>
                    <strong>KES ${parseFloat(pricing.base_price).toLocaleString()}</strong>
                </div>
                ${pricing.applied_pricing_rules && pricing.applied_pricing_rules.length > 0 ? 
                     pricing.applied_pricing_rules.map(rule => `
                        <div class="d-flex justify-content-between small mb-1">
                            <span class="text-muted">${rule.rule_name}:</span>
                            <span class="${rule.adjustment >= 0 ? 'text-danger' : 'text-success'}">
                                ${rule.adjustment >= 0 ? '+' : ''}KES ${Math.abs(rule.adjustment).toLocaleString()}
                            </span>
                        </div>
                    `).join('') : ''}
                <div class="d-flex justify-content-between mb-2">
                    <span>Tax (16%):</span>
                    <strong>KES ${parseFloat(pricing.tax_amount).toLocaleString()}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Service Charge:</span>
                    <strong>KES ${parseFloat(pricing.service_charge).toLocaleString()}</strong>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <strong>Total Amount:</strong>
                    <h5 class="text-primary mb-0">KES ${parseFloat(pricing.total_amount).toLocaleString()}</h5>
                </div>
            </div>
         </div>
         `;

   // Set deposit amount
   const depositAmount = pricing.total_amount * 0.3; // 30% deposit
   document.getElementById('depositAmount').textContent = `KES ${depositAmount.toLocaleString()}`;

   // Pre-fill payment form
   document.getElementById('paymentName').value = customer.customer_name;
   document.getElementById('paymentPhone').value = customer.customer_phone;

   const confirmModal = new bootstrap.Modal(document.getElementById('bookingConfirmationModal'));
   confirmModal.show();
}

// Handle Payment Form Submission
document.getElementById('paymentForm').addEventListener('submit', async function(e) {
   e.preventDefault();

   if (!document.getElementById('acceptTerms').checked) {
      alert('Please accept the terms and conditions');
      return;
   }

   const paymentData = {
      ...bookingData.customer,
      bookable_type: bookingData.selectedSpace.type === 'room' ? 'App\\Models\\Restaurant\\RstRoom' : 'App\\Models\\Restaurant\\RstTable',
      bookable_id: bookingData.selectedSpace.id,
      duration_hours: 2, // Default
      payment_name: document.getElementById('paymentName').value,
      payment_phone: document.getElementById('paymentPhone').value,
   };

   // Close confirmation modal
   bootstrap.Modal.getInstance(document.getElementById('bookingConfirmationModal')).hide();

   // Show processing modal
   const processingModal = new bootstrap.Modal(document.getElementById('paymentProcessingModal'));
   processingModal.show();

   try {
      const response = await fetch('/api/restaurant/create-booking', {
         method: 'POST',
         headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
         },
         body: JSON.stringify(paymentData)
      });

      const result = await response.json();

      if (result.success) {
         document.getElementById('processingBookingNumber').textContent = result.booking.booking_number;

         // Start polling payment status
         pollPaymentStatus(result.booking.id, 0);
      } else {
         processingModal.hide();
         alert(result.message || 'Booking failed. Please try again.');
      }
   } catch (error) {
      console.error('Error:', error);
      processingModal.hide();
      alert('An error occurred. Please try again.');
   }
});

// Poll Payment Status
function pollPaymentStatus(bookingId, attempts) {
   if (attempts >= 60) { // 2 minutes maximum
      window.location.href = `/bookings/${bookingId}/payment-pending`;
      return;
   }

   setTimeout(async () => {
      try {
         const response = await fetch(`/api/restaurant/bookings/${bookingId}/payment-status`);
         const result = await response.json();

         if (result.payment_status === 'paid') {
            window.location.href = `/bookings/${bookingId}/confirmation`;
         } else if (result.payment_status === 'failed') {
            window.location.href = `/bookings/${bookingId}/payment-failed`;
         } else {
            pollPaymentStatus(bookingId, attempts + 1);
         }
      } catch (error) {
         console.error('Error checking payment status:', error);
         pollPaymentStatus(bookingId, attempts + 1);
      }
   }, 2000);
}

// Set today's date as minimum
document.addEventListener('DOMContentLoaded', function() {
   const dateInput = document.querySelector('input[name="booking_date"]');
   const today = new Date().toISOString().split('T')[0];
   dateInput.setAttribute('min', today);
   dateInput.value = today;
});
