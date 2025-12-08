<div class="owl-carousel owl-theme" id="services-slide-{{$section->id}}">
   @foreach($services->take(4) as $key => $service)
      <div class="col-12" >
         <div class="mb-5">
            <div class="card service service-secondary shadow rounded overflow-hidden" data-aos="zoom-in-up" data-aos-duration="1000" data-aos-delay="{{ ($key + 1) * 200 }}">
               <div class="image position-relative overflow-hidden">
                  <img src="{{ $service->media[0]->original_url ?? asset('website/dummy_800x600.jpg') }}" alt="{{$service->slug}}"
                       class="img-fluid h-100" style="">
               </div>
               <div class="card-body content">
                  <a href="{{ route('services.show', $service->slug) }}" class="h5 title text-dark d-block mb-0">
{{--                     {!! Str::words($service->title, 2) !!}--}}
                     {{ $service->title }}
                  </a>
                  <div class="text-muted mt-2 mb-2">
                     {!! Str::words($service->details, 7) !!}
                  </div>
                  <a href="{{ route('services.show', $service->slug) }}" class="link text-dark">
                     Read More <i class="mdi mdi-arrow-right align-middle"></i>
                  </a>
               </div>
            </div>
         </div>
      </div>
   @endforeach
</div>


@push('scripts')
   <script>
      $('#services-slide-{{$section->id}}').owlCarousel({
         loop: true,
         margin: 10,
         autoplay: true,
         autoplayTimeout: 4000,
         autoplayHoverPause: false,
         smartSpeed: 1300,
         nav: false,
         responsive: {
            0: {
               items: 1
            },
            600: {
               items: 2
            },
            1000: {
               items: 3
            }
         }
      });
   </script>
@endpush
