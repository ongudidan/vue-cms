class ProductManager {
   constructor() {
      this.cartData = null;
      this.init();
      this.loadCartData();
   }

   init() {
      this.initQuantityControls();
      this.initCartForm();
      this.initOptionButtons();
      this.validateElements();
      this.initCartUpdateListeners();
   }

   // Load cart data on page load
   async loadCartData() {
      try {
         const response = await fetch('/cart/data', {
            method: 'GET',
            headers: {
               'Accept': 'application/json',
               'X-CSRF-TOKEN': this.getCsrfToken()
            }
         });

         const data = await response.json();

         if (data.success) {
            this.cartData = data;
            this.updateCartCount(data.cart_count);
         }
      } catch (error) {
         console.warn('Could not load cart data:', error);
      }
   }

   // Initialize cart update listeners (for cart page)
   initCartUpdateListeners() {
      // Quantity update buttons in cart
      document.querySelectorAll('.cart-qty-update').forEach(btn => {
         btn.addEventListener('click', (e) => {
            e.preventDefault();
            const itemId = e.currentTarget.dataset.itemId;
            const action = e.currentTarget.dataset.action;
            const qtyInput = e.currentTarget.closest('.qty-controls').querySelector('.cart-qty-input');
            const currentQty = parseInt(qtyInput.value);

            let newQty = currentQty;
            if (action === 'increase') {
               ++newQty;
            } else if (action === 'decrease' && currentQty > 1) {
               --newQty;
            }

            qtyInput.value = newQty;
            this.updateCartItem(itemId, newQty);
         });
      });

      // Remove item buttons
      document.querySelectorAll('.remove-cart-item').forEach(btn => {
         btn.addEventListener('click', (e) => {
            e.preventDefault();
            const itemId = e.currentTarget.dataset.itemId;
            this.removeCartItem(itemId);
         });
      });

      // Direct quantity input changes
      document.querySelectorAll('.cart-qty-input').forEach(input => {
         input.addEventListener('input', (e) => {
            const newQty = parseInt(e.target.value) || 1;

            if (newQty < 1) {
               e.target.value = 1;
               return;
            }
         });
      });
   }

   // Update cart item quantity
   async updateCartItem(itemId, quantity) {
      try {
         const response = await fetch(`/cart/update/${itemId}`, {
            method: 'POST',
            headers: {
               'Content-Type': 'application/json',
               'Accept': 'application/json',
               'X-CSRF-TOKEN': this.getCsrfToken()
            },
            body: JSON.stringify({ quantity })
         });

         const data = await response.json();

         if (data.success) {
            this.updateCartCount(data.cart_count);
            this.updateCartDisplay(data, itemId);
            toastr.success(data.message, 'Success');
         } else {
            toastr.error(data.message || 'Failed to update cart', 'Error');
         }
      } catch (error) {
         console.error('Error updating cart item:', error);
         toastr.error('Failed to update cart item', 'Error');
      }
   }

   async removeCartItem(itemId) {
      if (!confirm('Are you sure you want to remove this item from your cart?')) {
         return;
      }

      try {
         const response = await fetch(`/cart/remove/${itemId}`, {
            method: 'DELETE',
            headers: {
               'Accept': 'application/json',
               'X-CSRF-TOKEN': this.getCsrfToken()
            }
         });

         const data = await response.json();

         if (data.success) {
            this.updateCartCount(data.cart_count);
            this.removeCartItemFromDOM(itemId);
            this.updateCartDisplay(data);
            toastr.success(data.message || 'Item removed from cart', 'Success');
         } else {
            toastr.error(data.message || 'Failed to remove item', 'Error');
         }
      } catch (error) {
         console.error('Error removing cart item:', error);
         toastr.error('Failed to remove cart item', 'Error');
      }
   }

   updateCartDisplay(data, itemId = null) {
      const cartTotalEl = document.querySelector('.cart-total, [data-cart-total]');
      if (cartTotalEl && data.cart_total !== undefined) {
         cartTotalEl.textContent = this.formatPrice(data.cart_total);
      }

      const cartSubtotalEl = document.querySelector('.cart-subtotal, [data-cart-subtotal]');
      if (cartSubtotalEl && data.cart_subtotal !== undefined) {
         cartSubtotalEl.textContent = this.formatPrice(data.cart_subtotal);
      }

      if (itemId && data.line_total !== undefined) {
         const itemRow = document.querySelector(`tr[data-cart-item="${itemId}"]`);
         if (itemRow) {
            const lineTotalEl = itemRow.querySelector('.line-total, td:last-child');
            if (lineTotalEl) {
               lineTotalEl.textContent = this.formatPrice(data.line_total);
            }
         }
      }
   }

   removeCartItemFromDOM(itemId) {
      const itemRow = document.querySelector(`tr[data-cart-item="${itemId}"]`);
      if (itemRow) {
         itemRow.style.transition = 'opacity 0.3s ease';
         itemRow.style.opacity = '0';

         setTimeout(() => {
            itemRow.remove();
            this.checkEmptyCart();
         }, 300);
      }
   }

   checkEmptyCart() {
      const cartItems = document.querySelectorAll('[data-cart-item]');
      if (cartItems.length === 0) {
         const container = document.querySelector('.container.cart');
         if (container) {
            container.innerHTML.trim();
            container.innerHTML = `
               <div class="row">
                  <div class="col-12">
                     <div class="empty-cart text-center py-5">
                        <div class="mb-4">
                           <i class="uil uil-shopping-cart-alt" style="font-size: 4rem; color: #adb5bd;"></i>
                        </div>
                        <h4>Your cart is empty</h4>
                        <p class="text-muted">Add some products to get started!</p>
                     </div>
                  </div>
               </div>
            `;
         }
      }
   }

   // Format price for display
   formatPrice(priceInCents) {
      return 'KSh ' + new Intl.NumberFormat('en-KE', {
         minimumFractionDigits: 2,
         maximumFractionDigits: 2
      }).format(priceInCents / 100);
   }

   // Get CSRF token
   getCsrfToken() {
      const tokenMeta = document.querySelector('meta[name="csrf-token"]');
      const tokenInput = document.querySelector('input[name="_token"]');

      return tokenMeta?.getAttribute('content') ||
         tokenInput?.value ||
         '';
   }

   // Validate that required elements exist
   validateElements() {
      const form = document.getElementById('addToCartForm');
      if (!form) return;

      const required = ['selected_quantity', 'total_price', 'adjusted_price'];
      const missing = required.filter(id => !document.getElementById(id));

      if (missing.length > 0) {
         console.warn('Missing required elements:', missing);
      }
   }

   initQuantityControls() {
      document.querySelectorAll('.qty-icons').forEach(wrapper => {
         const input = wrapper.querySelector('.quantity');
         const qtyInput = document.getElementById('selected_quantity');
         const minusBtn = wrapper.querySelector('.minus');
         const plusBtn = wrapper.querySelector('.plus');

         if (!input || !qtyInput || !minusBtn || !plusBtn) {
            return;
         }

         // Set initial quantity
         qtyInput.value = input.value || 1;
         this.recalcTotal();

         minusBtn.addEventListener('click', () => {
            if (input.value > (input.min || 1)) {
               input.stepDown();
               qtyInput.value = input.value;
               this.recalcTotal();
            }
         });

         plusBtn.addEventListener('click', () => {
            const maxQty = input.max || 999;
            if (parseInt(input.value) < parseInt(maxQty)) {
               input.stepUp();
               qtyInput.value = input.value;
               this.recalcTotal();
            }
         });

         input.addEventListener('input', () => {
            qtyInput.value = input.value;
            this.recalcTotal();
         });
      });
   }

   recalcTotal() {
      try {
         const basePriceEl = document.querySelector('input[name="base_price"]');
         const adjustedPriceEl = document.getElementById('adjusted_price');
         const qtyEl = document.getElementById('selected_quantity');
         const totalEl = document.getElementById('total_price');

         if (!basePriceEl || !adjustedPriceEl || !qtyEl || !totalEl) {
            return;
         }

         const basePrice = parseInt(basePriceEl.value) || 0;
         const adjustedPrice = parseInt(adjustedPriceEl.value) || 0;
         const qty = parseInt(qtyEl.value) || 1;

         const total = (basePrice + adjustedPrice) * qty;
         totalEl.value = total;

         this.updateDisplayPrice(basePrice, adjustedPrice);

      } catch (error) {
         console.error('Error calculating total:', error);
      }
   }

   updateDisplayPrice(basePrice, adjustedPrice) {
      const priceDisplay = document.querySelector('.product-price, .price');
      if (priceDisplay && basePrice !== undefined) {
         const basePriceFormatted = (basePrice * 0.01).toFixed(2);
         const adjustedPriceFormatted = (adjustedPrice * 0.01).toFixed(2);

         if (adjustedPrice > 0) {
            priceDisplay.textContent = `KSh ${basePriceFormatted} + ${adjustedPriceFormatted}`;
         } else {
            priceDisplay.textContent = `KSh ${basePriceFormatted}`;
         }
      }
   }

   initCartForm() {
      const forms = document.querySelectorAll('.add-to-cart-form');

      forms.forEach(form => {
         form.addEventListener('submit', async (e) => {
            e.preventDefault();
            await this.addToCart(form);
         });
      });
   }

   async addToCart(form) {
      const productId = form.querySelector('input[name="product_id"]').value;
      const submitBtn = document.getElementById(`submit-cart-${productId}`);
      const originalText = submitBtn.textContent;
      console.log(submitBtn.textContent);
      try {
         if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.dataset.originalText = originalText;
            submitBtn.textContent = 'Adding...';
         }

         const formData = new FormData(form);

         const response = await fetch(form.action, {
            method: "POST",
            headers: {
               'X-CSRF-TOKEN': this.getCsrfToken(),
               'Accept': 'application/json'
            },
            body: formData
         });

         const data = await response.json();

         if (data.success) {
            toastr.success(data.message || "Added to cart!", 'Success');
            this.updateCartCount(data.cart_count);
            this.resetProductForm();
         } else {
            toastr.error(data.message || "Failed to add to cart", 'Error');
         }

      } catch (error) {
         console.error('Error adding to cart:', error);
         toastr.error("An error occurred. Please try again.", 'Error');
      } finally {
         if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText || 'Add to Cart';
         }
      }
   }

   resetProductForm() {
      const qtyInput = document.getElementById('selected_quantity');
      const qtyControls = document.querySelectorAll('.quantity');

      if (qtyInput) qtyInput.value = 1;
      qtyControls.forEach(input => input.value = 1);

      document.querySelectorAll('.option-btn').forEach(btn => {
         btn.classList.remove('active', 'selected');
      });

      const selectedOptionEl = document.getElementById('selected_option');
      const adjustedPriceEl = document.getElementById('adjusted_price');

      if (selectedOptionEl) selectedOptionEl.value = '';
      if (adjustedPriceEl) adjustedPriceEl.value = 0;

      this.recalcTotal();
   }

   updateCartCount(count) {
      const cartCountElements = document.querySelectorAll('.cart-count, #cart-count');

      cartCountElements.forEach(el => {
         if (el && count !== undefined) {
            el.textContent = count;
            el.classList.add('updated');
            setTimeout(() => el.classList.remove('updated'), 300);
         }
      });
   }

   initOptionButtons() {
      document.querySelectorAll('.option-btn').forEach(btn => {
         btn.addEventListener('click', (e) => {
            this.handleOptionSelection(e.currentTarget);
         });
      });
   }

   handleOptionSelection(btn) {
      try {
         document.querySelectorAll('.option-btn').forEach(b =>
            b.classList.remove('active', 'selected')
         );

         btn.classList.add('active');

         const optionId = btn.dataset.optionId;
         const adjustPrice = parseInt(btn.dataset.adjustedPrice) || 0;

         const selectedOptionEl = document.getElementById('selected_option');
         const adjustedPriceEl = document.getElementById('adjusted_price');

         if (selectedOptionEl) selectedOptionEl.value = optionId;
         if (adjustedPriceEl) adjustedPriceEl.value = adjustPrice;

         this.recalcTotal();
         this.updateProductTitle(btn.textContent.trim());

      } catch (error) {
         console.error('Error handling option selection:', error);
      }
   }

   updateProductTitle(optionText) {
      const productTitle = document.querySelector('.product-title, .section-title h4');

      if (productTitle) {
         if (!productTitle.dataset.baseName) {
            productTitle.dataset.baseName = productTitle.textContent.split(' (')[0];
         }
         productTitle.textContent = `${productTitle.dataset.baseName} (${optionText})`;
      }
   }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
   window.productManager = new ProductManager();
});

// Refresh cart data when page becomes visible
document.addEventListener('visibilitychange', () => {
   if (!document.hidden && window.productManager) {
      window.productManager.loadCartData();
   }
});
