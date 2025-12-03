@include('website.shared.page-banner', ['title' => $page->title])

<section class="section">
   <div class="container">
      <div class="row">
         <div class="col-12 col-xl-5 col-md-12">
            <div class="mb-md-3 mb-3">
               <div class="image-layered" data-aos="fade-right" data-aos-duration="1000" data-aos-delay="100">
                  <img src="{{ asset('website/images/mombasa-port.jpg') }}" alt="">
               </div>
            </div>
         </div>
         <div class="col-12 col-xl-7 col-md-12">
            <div class="section-margin">
               <div class="section-subheading" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="100">
                  <span>
                     About Us
                  </span>
               </div>
               <div data-aos="fade-left" data-aos-duration="1000" data-aos-delay="300">
                  <h1 class="section-heading">
                     We Provide quick & safe transportation all over the world
                  </h1>
                  <p class="section-details">
                     Musa Rambo Logistics Kenya Limited, incorporated in 2010 under the Companies Act (Cap 486) of the Laws of Kenya, is a prominent provider of shipping and logistics services. Spearship Contractors, with headquarters in Mombasa and a branch in Nairobi, is well-known for providing dependable, efficient, and cost-effective shipping and logistics services. We are strategically placed at the contemporary MSC Plaza near the Mombasa Port, in the center of Kenya’s maritime industry, allowing us to meet our clients’ diversified needs.
                  </p>
                  <p class="section-details">
                     Musa Rambo Logistics Kenya Limited is dedicated to delivering high-quality shipping consultation, shipping services, tally and lashing solutions, as well as a wide range of logistics services through our branch, Spears Logistics. Our mission is to be known as Kenya’s most competent, innovative, and influential shipping and logistics company. Customer satisfaction is our primary focus, and we endeavor to provide cheap rates without sacrificing quality. With over 40 years of expertise in the shipping and logistics sector, our chief executive, Mr. Mohamed Yusuf Mohamed, leads a team of almost 50 qualified permanent employees and over 150 casual laborers, assuring smooth operations both inside and outside the Mombasa port.
                  </p>
                  <div class="section-analysis mt-5">
                     <div class="col-12">
                        <a href="{{ $servicesPage->slug ?? '#' }}" class="primary-btn {{ $customisation->button_style ?? '' }}">See Our Services</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
