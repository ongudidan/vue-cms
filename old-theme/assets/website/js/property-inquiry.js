document.addEventListener('DOMContentLoaded', () => {
   const form       = document.getElementById('propertyInquiryForm');
   const submitBtn  = document.getElementById('submitInquiry');
   const btnText    = submitBtn.querySelector('.btn-text');
   const simpleMsg  = document.getElementById('simple-msg');
   const csrfToken  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

   form.addEventListener('submit', handleSubmit);

   async function handleSubmit(e) {
      e.preventDefault();
      clearMessages();
      clearFieldErrors();

      const { property_id, name, email, phone, inquiry_type, message } = Object.fromEntries(new FormData(form));
      let hasErrors = false;

      // --- Client-side validation ---
      if (!name) {
         showFieldError('name', 'Please enter your name.');
         hasErrors = true;
      }
      if (!email) {
         showFieldError('email', 'Please enter your email.');
         hasErrors = true;
      }
      if (!inquiry_type) {
         showFieldError('message', 'Please select an inquiry type');
         hasErrors = true;
      }
      if (!message) {
         showFieldError('message', 'Please enter a message.');
         hasErrors = true;
      }

      if (hasErrors) return;

      disableButton();

      try {
         const response = await fetch('/send-inquiry', {
            method: 'POST',
            headers: {
               'Content-Type': 'application/json',
               'Accept': 'application/json',
               'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ property_id, name, email, phone, inquiry_type, message })
         });

         if (response.status === 429) {
            simpleMsg.innerHTML = "<div class='alert alert-danger'>Too many attempts. Try again later</div>";
            form.reset();
            setTimeout(() => {
               simpleMsg.innerHTML = '';
            }, 5000);
            return;
         }

         const data = await safeJson(response);

         if (response.ok) {
            simpleMsg.innerHTML = "<div class='alert alert-success'>Your inquiry has been sent.</div>";
            form.reset();
            setTimeout(() => {
               simpleMsg.innerHTML = '';
            }, 5000);
         } else if (response.status === 422 && data?.errors) {
            // --- Laravel server-side validation errors ---
            Object.entries(data.errors).forEach(([field, messages]) => {
               showFieldError(field, messages[0]);
            });
         } else {
            simpleMsg.innerHTML = "<div class='alert alert-danger'>Something went wrong. Please try again later.</div>";
            console.error('Unexpected error:', data);
         }

      } catch (err) {
         console.error(err);
         simpleMsg.innerHTML = "<div class='alert alert-danger'>Network error. Please try again later.</div>";
      } finally {
         enableButton();
      }
   }

   // --- Helper functions ---

   function disableButton() {
      submitBtn.disabled = true;
      submitBtn.setAttribute('aria-busy', 'true');
      btnText.textContent = 'Sending...';
   }

   function enableButton() {
      submitBtn.disabled = false;
      submitBtn.removeAttribute('aria-busy');
      btnText.textContent = 'Send Message';
   }

   function showFieldError(field, message) {
      const input = document.getElementById(field);
      if (!input) return;

      const feedback = input.parentElement.querySelector('.invalid-feedback');
      input.classList.add('is-invalid');
      if (feedback) {
         feedback.textContent = message;
      }
   }

   function clearFieldErrors() {
      document.querySelectorAll('.form-control').forEach(input => {
         input.classList.remove('is-invalid');
         const feedback = input.parentElement.querySelector('.invalid-feedback');
         if (feedback) feedback.textContent = '';
      });
   }

   function clearMessages() {
      simpleMsg.innerHTML = "";
   }

   async function safeJson(response) {
      try {
         return await response.json();
      } catch {
         return null;
      }
   }
});
