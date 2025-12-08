<div class="owl-carousel owl-theme" id="projects-slide-{{$section->id}}">
   @foreach($projects->take(4) as $key => $project)
      <div class="col-12">
         <div class="mb-5">
            <div class="card shadow rounded overflow-hidden" data-aos="zoom-in-up" data-aos-duration="1000" data-aos-delay="{{ ($key + 1) * 200 }}">
               <div class="image position-relative overflow-hidden">
                  <img src="{{ $project->media[0]->original_url ?? asset('website/dummy_800x600.jpg') }}" alt="{{$project->slug}}"
                       class="img-fluid rounded-bottom-0 w-100" style="height:270px;">
               </div>
               <div class="card-body content">
                  <a href="{{ route('projects.show', $project->slug) }}" class="h5 title text-dark d-block mb-0">
                     {{ $project->title }}
                  </a>
                  <div class="text-muted mt-2 mb-2">
                     {!! Str::words($project->details, 7) !!}
                  </div>
                  <a href="{{ route('projects.show', $project->slug) }}" class="link text-dark">
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
      $('#projects-slide-{{$section->id}}').owlCarousel({
         loop: true,
         margin: 30,
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
