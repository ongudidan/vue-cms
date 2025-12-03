<div class="home-dashboard position-relative mt-60 mt-100 w__95 mx-auto">
   <div class="col-12">
      <button id="showBookingBtn" class="booking-toggle-btn btn btn-secondary rounded-0">
         <i class="ti ti-calculator"></i> Book Now
      </button>
      <div class="card bg-translucent rounded-0 booking-form" id="bookingForm">
         <div class="card-body">
            <button type="button" id="closeBookingBtn" class="btn-close position-absolute top-0 end-0 m-3 d-lg-none d-block"></button>
            <form id="quickBookingForm" class="row mt-3">
               @csrf
               <div class="col-md-3 col-12 mb-2">
                  <input type="text" name="customer_name" class="form-control rounded-0"
                         placeholder="Name" required />
               </div>
               <div class="col-md-3 col-12 mb-2">
                  <input type="email" name="customer_email" class="form-control rounded-0"
                         placeholder="Email" required />
               </div>
               <div class="col-md-3 col-12 mb-2">
                  <input type="tel" name="customer_phone" class="form-control rounded-0"
                         placeholder="Phone (254712345678)" required />
               </div>
               <div class="col-md-3 col-12 mb-2">
                  <input type="number" name="guest_count" class="form-control rounded-0"
                         placeholder="No of guests" min="1" required />
               </div>
               <div class="col-md-3 col-12 mb-2">
                  <input type="date" name="booking_date" class="form-control rounded-0"
                         placeholder="Date" required />
               </div>
               <div class="col-md-3 col-12 mb-2">
                  <input type="time" name="booking_time" class="form-control rounded-0"
                         placeholder="Time" required />
               </div>
               <div class="col-md-3 col-12 mb-2">
                  <select name="booking_type" class="form-control rounded-0" required>
                     <option value="">Select Booking Type</option>
                     <option value="reservation">Reservation</option>
                     <option value="event">Event</option>
                     <option value="party">Party</option>
                  </select>
               </div>
               <div class="col-md-3 col-12 mb-2">
                  <select name="space_type" class="form-control rounded-0" required>
                     <option value="">Select Space Type</option>
                     <option value="room">Room</option>
{{--                     <option value="table">Table</option>--}}
                  </select>
               </div>
               <div class="col-md-3 col-12 text-start mt-1">
                  <button type="submit" class="btn btn-primary rounded-0">
                     Book Now
                  </button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
