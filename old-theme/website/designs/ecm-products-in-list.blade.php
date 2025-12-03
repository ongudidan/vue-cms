<section class="section pt-5 bg-white">
   <div class="bg-overlay bg-gradient-overlay-white"></div>
   <div @class([
       $customisation->section_width_style ?? 'container',
       'w__' . ($customisation->section_width ?? '100'), 'mt-5' ])
   >
      <div class="row">
         @foreach($ecmProducts->take(12) as $key => $product)
         <div class="col-lg-6 col-md-6" data-aos="zoom-in-up" data-aos-duration="1800" data-aos-delay="{{ ($key + 1) * 300 }}">
            <div class="portfolio portfolio-primary d-flex align-items-center p-2 pt-3 pb-3">
               <img src="{{ $product->media[0]->original_url ?? asset('website/dummy_450x450.jpg') }}" class="img-fluid shadow rounded-pill avatar avatar-md-md shadow-md" alt="img">
               <div class="flex-1 ms-4 w-100">
                  <div class="d-flex justify-content-between border-bottom pb-2">
                     <a href="{{ route('ecm.products.show', $product->slug) }}" class="text-dark title h6 mb-0 fw-semibold">
                        {{ $product->name }}
                     </a>
                     <span class="float-end fw-semibold">{{ $product->shop->currency->iso . ' ' . number_format(($product->base_price * 0.01), 0, 2) }}</span>
                  </div>
                  <div class="text-muted mb-0 mt-2 details">{!! $product->description !!}</div>
               </div>
            </div>
         </div>
         @endforeach
      </div>
   </div>
</section>
