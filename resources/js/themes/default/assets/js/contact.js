document.addEventListener('DOMContentLoaded', () => {
    const form       = document.getElementById('contactForm');
    const submitBtn  = document.getElementById('submitContactForm');
    const btnText    = submitBtn.querySelector('.btn-text');
    const simpleMsg  = document.getElementById('simple-msg');
    const csrfToken  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    form.addEventListener('submit', handleSubmit);

    async function handleSubmit(e) {
        e.preventDefault();
        clearMessages();
        clearFieldErrors();

        const { name, email, subject, comments } = Object.fromEntries(new FormData(form));
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
        if (!subject) {
            showFieldError('subject', 'Please the subject of your message.');
            hasErrors = true;
        }
        if (!comments) {
            showFieldError('comments', 'Please enter a message.');
            hasErrors = true;
        }

        if (hasErrors) return;

        disableButton();

        try {
            const response = await fetch('/send-message', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ name, email, subject, comments })
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
                simpleMsg.innerHTML = "<div class='alert alert-success'>Your message has been sent.</div>";
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
