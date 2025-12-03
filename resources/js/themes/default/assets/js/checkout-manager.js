class CheckoutManager {
   constructor() {
      this.form = document.getElementById('manual-checkout-form');
      this.submitButton = null;
      this.billingCheckbox = document.getElementById('is_billing');
      this.init();
   }

   init() {
      if (!this.form) {
         console.warn('Checkout form not found');
         return;
      }

      // console.log('Checkout form found, initializing...');
      this.submitButton = this.form.querySelector('button[type="submit"]');
      this.setupFormValidation();
      this.setupFormSubmission();
   }

   setupFormValidation() {
      // Real-time validation for M-Pesa reference
      const mpesaRefInput = document.getElementById('mpesa_reference_no');
      if (mpesaRefInput) {
         mpesaRefInput.addEventListener('input', (e) => {
            const value = e.target.value.toUpperCase();
            e.target.value = value;

            // M-Pesa transaction codes are typically 10 characters
            if (value.length > 0 && value.length < 10) {
               e.target.setCustomValidity('M-Pesa code should be at least 10 characters');
            } else {
               e.target.setCustomValidity('');
            }
         });
      }

      // Email validation
      const emailInput = document.getElementById('customer_email');
      if (emailInput) {
         emailInput.addEventListener('blur', (e) => {
            const value = e.target.value.trim();
            if (value.length > 0) {
               const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
               if (!emailPattern.test(value)) {
                  e.target.setCustomValidity('Please enter a valid email address');
                  e.target.classList.add('is-invalid');
               } else {
                  e.target.setCustomValidity('');
                  e.target.classList.remove('is-invalid');
               }
            }
         });
      }
   }

   setupFormSubmission() {
      this.form.addEventListener('submit', async (e) => {
         e.preventDefault();
         console.log('Form submitted');
         await this.handleCheckout();
      });
   }

   async handleCheckout() {
      console.log('Handling checkout...');

      // Validate form
      if (!this.form.checkValidity()) {
         this.form.classList.add('was-validated');

         // Find first invalid field and focus it
         const firstInvalid = this.form.querySelector(':invalid');
         if (firstInvalid) {
            firstInvalid.focus();

            // Check if toastr exists
            if (typeof toastr !== 'undefined') {
               toastr.error('Please fill in all required fields correctly', 'Validation Error');
            } else {
               alert('Please fill in all required fields correctly');
            }
         }
         return;
      }

      // Show loading state
      this.setLoadingState(true);

      try {
         const formData = new FormData(this.form);

         console.log('Sending request to:', this.form.action);

         const response = await fetch(this.form.action, {
            method: 'POST',
            headers: {
               'X-CSRF-TOKEN': this.getCsrfToken(),
               'Accept': 'application/json'
            },
            body: formData
         });

         console.log('Response status:', response.status);

         const data = await response.json();
         console.log('Response data:', data);

         if (data.success) {
            // Check if toastr exists
            if (typeof toastr !== 'undefined') {
               toastr.success(data.message || 'Order placed successfully!', 'Success');
            } else {
               alert(data.message || 'Order placed successfully!');
            }

            // Show success message
            this.showSuccessMessage(data);

            // Redirect after 2 seconds
            setTimeout(() => {
               window.location.href = data.redirect_url || '/';
            }, 2000);
         } else {
            // Check if toastr exists
            if (typeof toastr !== 'undefined') {
               toastr.error(data.message || 'Failed to place order. Please try again.', 'Error');
            } else {
               alert(data.message || 'Failed to place order. Please try again.');
            }
            this.setLoadingState(false);
         }

      } catch (error) {
         console.error('Checkout error:', error);

         // Check if toastr exists
         if (typeof toastr !== 'undefined') {
            toastr.error('An error occurred. Please try again or contact support.', 'Error');
         } else {
            alert('An error occurred. Please try again or contact support.');
         }
         this.setLoadingState(false);
      }
   }

   setLoadingState(loading) {
      if (!this.submitButton) return;

      if (loading) {
         this.submitButton.disabled = true;
         this.submitButton.innerHTML = `
                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                Processing Order...
            `;
      } else {
         this.submitButton.disabled = false;
         this.submitButton.innerHTML = 'Place Your Order';
      }
   }

   showSuccessMessage(data) {
      const successHtml = `
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="uil uil-check-circle fs-5"></i>
                <strong>Order Placed Successfully!</strong><br>
                Order Number: <strong>${data.order_number || 'N/A'}</strong><br>
                ${data.customer_email ? 'A confirmation email has been sent to your email address.' : ''}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;

      // Insert at top of form
      this.form.insertAdjacentHTML('beforebegin', successHtml);

      // Scroll to top
      window.scrollTo({ top: 0, behavior: 'smooth' });
   }

   getCsrfToken() {
      const tokenMeta = document.querySelector('meta[name="csrf-token"]');
      const tokenInput = this.form.querySelector('input[name="_token"]');

      return tokenMeta?.getAttribute('content') ||
         tokenInput?.value ||
         '';
   }

   // Utility: Format currency
   formatPrice(priceInCents) {
      return 'KSh ' + new Intl.NumberFormat('en-KE', {
         minimumFractionDigits: 2,
         maximumFractionDigits: 2
      }).format(priceInCents / 100);
   }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
   // console.log('DOM loaded, initializing CheckoutManager...');
   window.checkoutManager = new CheckoutManager();
});

// Add custom styling for validation
const style = document.createElement('style');
style.textContent = `
    .was-validated .form-control:invalid {
        border-color: #dc3545;
        padding-right: calc(1.5em + 0.75rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }
    
    .was-validated .form-control:valid {
        border-color: #198754;
        padding-right: calc(1.5em + 0.75rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }
    
    .form-control:invalid:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
    }
    
    .spinner-border-sm {
        width: 1rem;
        height: 1rem;
        border-width: 0.2em;
    }
`;
document.head.appendChild(style);
