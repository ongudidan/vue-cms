<div class="row">
   @foreach($services as $key => $service)
   <div class="col-12 col-xl-4 col-lg-4 col-md-6">
      <div class="mb-5">
         <div class="card service service-secondary shadow rounded overflow-hidden" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="{{ $key * 100 }}">
            <div class="image position-relative overflow-hidden">
               <img src="{{ $service->media[0]->original_url ?? asset('website/dummy_800x600.jpg') }}" class="img-fluid" alt="">
            </div>
            <div class="card-body content">
               <a href="{{ route('services.show', $service->slug) }}" class="h5 title text-dark d-block mb-0">
                  {!! Str::words($service->title, 2) !!}
               </a>
               <div class="text-muted mt-2 mb-2">
                  {!! Str::words($service->details, 7) !!}
               </div>
               <a href="{{ route('services.show', $service->slug) }}" class="link text-dark">
                  Read More
                  <i class="mdi mdi-arrow-right align-middle"></i>
               </a>
            </div>
         </div>
      </div>
   </div>
   @endforeach
</div>
