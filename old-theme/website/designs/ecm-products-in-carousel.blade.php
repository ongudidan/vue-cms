<section class="section pb-0">
   <div @class([
       $customisation->section_width_style ?? 'container',
       'w__' . ($customisation->section_width ?? '100') ])
   >
      <div class="row">
         <div class="col-12 px-0" data-aos="zoom-in-up" data-aos-duration="1800" data-aos-delay="400">
            <div class="tiny-twelve-item">
               @foreach($ecmProducts->take(15) as $product)
               <div class="tiny-slide">
                  <div class="card portfolio portfolio-classic portfolio-primary client-testi overflow-hidden">
                     <div class="card-img position-relative">
                        <img src="{{ $product->media[0]->original_url ?? asset('website/dummy_450x450.jpg') }}" class="img-fluid rounded" alt="">
                        <div class="card-overlay"></div>

                        <div class="pop-icon">
                           <a href="{{ route('ecm.products.show', $product->slug) }}" class="btn btn-pills btn-icon"><i class="uil uil-search"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
               @endforeach
            </div>
         </div>
      </div>
   </div>
</section>

@push('scripts')
   <script>
      document.addEventListener("DOMContentLoaded", function() {
         if(document.querySelector('.tiny-twelve-item')) {
            tns({
               container: '.tiny-twelve-item',
               controls: true,
               mouseDrag: true,
               loop: true,
               rewind: true,
               autoplay: true,
               autoplayButtonOutput: false,
               autoplayTimeout: 3000,
               navPosition: "bottom",
               controlsText: ['<i class="mdi mdi-chevron-left "></i>', '<i class="mdi mdi-chevron-right"></i>'],
               nav: false,
               speed: 400,
               gutter: 0,
               responsive: {
                  1025: {
                     items: 10
                  },

                  992: {
                     items: 8
                  },

                  767: {
                     items: 6
                  },

                  320: {
                     items: 2
                  },
               },
            });
         }
      });
   </script>
@endpush
