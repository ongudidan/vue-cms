@include('website.shared.page-banner', ['title' => $page->title])

<section class="section contact">
   <div class="container">
      <div class="row">
         <div class="col-12 col-xl-5 col-md-6">
{{--               <div class="section-subheading">--}}
{{--                  <span>Contact Us</span>--}}
{{--               </div>--}}
            <h2 class="section-heading" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
               Reach Out To Us!
            </h2>
            <div class="contact-card mb-4" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
               <div class="contact-card-body">
                  <div class="row">
                     <div class="col-2 align-content-center">
                        <div class="contact-icon">
                           <i class="fa-solid fa-envelope"></i>
                        </div>
                     </div>
                     <div class="col-10">
                        <div class="contact-details">
                           <h4>Email</h4>
                           <p>{{ $company->email ?? '' }}</p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="contact-card mb-4" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
               <div class="contact-card-body">
                  <div class="row">
                     <div class="col-2 align-content-center">
                        <div class="contact-icon">
                           <i class="fa-solid fa-phone-volume"></i>
                        </div>
                     </div>
                     <div class="col">
                        <div class="contact-details">
                           <h4>Phone</h4>
                           <p>{{ $company->primary_phone }}</p>
                           <p>{{ $company->secondary_phone }}</p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="contact-card mb-4" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
               <div class="contact-card-body">
                  <div class="row">
                     <div class="col-2 align-content-center">
                        <div class="contact-icon">
                           <i class="fa-solid fa-location-dot"></i>
                        </div>
                     </div>
                     <div class="col-10">
                        <div class="contact-details">
                           <h4>Location</h4>
                           <p>{{ $company->physical_address ?? '' }}</p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-12 col-xl-7 col-md-6">
            <h2 class="section-heading" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
               Send Us A Message
            </h2>
            <div class="contact-form" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
               <form action="" method="POST">
                  @csrf
                  <div class="row gx-3">
                     <div class="col-12 col-md-12">
                        <div class="mb-3">
                           <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                           <input id="name" type="text" class="form-control" placeholder="Your name">
                        </div>
                     </div>
                     <div class="col-12 col-md-6">
                        <div class="mb-3">
                           <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                           <input id="email" type="email" class="form-control" placeholder="Email address">
                        </div>
                     </div>
                     <div class="col-12 col-md-6">
                        <div class="mb-3">
                           <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                           <input id="phone" type="text" class="form-control" placeholder="Phone number">
                        </div>
                     </div>
                     <div class="col-12 col-md-12">
                        <div class="mb-3">
                           <label for="subject" class="form-label">Subject <span class="text-danger">*</span></label>
                           <input id="subject" type="text" class="form-control" placeholder="Subject">
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="mb-3">
                           <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                           <textarea rows="5" id="message" class="form-control" placeholder="Your message goes here..."></textarea>
                        </div>
                     </div>
                  </div>
                  <button type="submit" class="primary-btn {{ $customisation->button_style ?? '' }}">Submit</button>
               </form>
            </div>
         </div>
      </div>
   </div>
</section>
<section class="section map" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
   <div class="container">
      <iframe loading="lazy"
              class="w-100 h-100"
              src="https://maps.google.com/maps?q=Kim%20and%20kid%2CACK%20Mombasa%20Cathedral%20Complex%2C%204th%20Floor%20-%20Nkrumah%20Rd&amp;t=m&amp;z=10&amp;output=embed&amp;iwloc=near" title="Kim and kid,ACK Mombasa Cathedral Complex, 4th Floor - Nkrumah Rd" aria-label="Kim and kid,ACK Mombasa Cathedral Complex, 4th Floor - Nkrumah Rd">
      </iframe>
   </div>
</section>
