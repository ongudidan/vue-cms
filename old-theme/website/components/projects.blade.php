<div class="row">
   @foreach($projects as $key => $project)
   <div class="col-lg-4 col-md-6 mb-4 pb-2 picture-item">
      <div class="card blog blog-primary shadow rounded overflow-hidden">
         <div class="image position-relative overflow-hidden">
            <img src="{{ $project->media[0]->original_url ?? asset('website/dummy_800x600.jpg') }}" alt=""
                 class="img-fluid w-100" style="height:250px;">

            <div class="blog-tag">
               <a href="javascript:void(0)" class="badge text-bg-light">{{ $project->category?->name }}</a>
            </div>
         </div>

         <div class="card-body content">
            <a href="{{ route('projects.show', [$project->slug]) }}" class="h5 title text-dark d-block mb-0">
               {{ $project->title }}
            </a>
            <p class="text-muted mt-2 mb-2">{!! \Str::words($project->details, 7) !!}</p>
            <a href="{{ route('projects.show', [$project->slug]) }}" class="link text-dark">
               Read More <i class="mdi mdi-arrow-right align-middle"></i>
            </a>
         </div>
      </div>
   </div>
   @endforeach
</div>



{{--<div class="col-lg-6 mb-4 pb-2">--}}
{{--   <div class="card blog blog-primary shadow rounded overflow-hidden">--}}
{{--      <div class="row align-items-center g-0">--}}
{{--         <div class="col-md-6">--}}
{{--            <div class="image card-img position-relative overflow-hidden">--}}
{{--               <img src="{{ $project->media[0]->original_url ?? asset('website/dummy_800x600.jpg') }}" class="" alt=""--}}
{{--                    style="width: 200px;">--}}
{{--               <div class="card-overlay"></div>--}}
{{--               <div class="blog-tag">--}}
{{--                  <a href="javascript:void(0)" class="badge text-bg-light">--}}
{{--                     {{ $project->category?->name }}--}}
{{--                  </a>--}}
{{--               </div>--}}
{{--            </div>--}}
{{--         </div>--}}
{{--         <div class="col-md-6">--}}
{{--            <div class="card-body content">--}}
{{--               <a href="{{ route('projects.show', [$project->slug]) }}" class="h5 title d-block mb-0">--}}
{{--                  {!! Str::words($project->title, 3) !!}--}}
{{--                  --}}{{--                  {{ $project->title }}--}}
{{--               </a>--}}
{{--               <div class="text-muted mt-2 mb-2 lh-1" style="line-height: 0">{!! \Str::words($project->details, 7) !!}</div>--}}
{{--               <a href="{{ route('projects.show', [$project->slug]) }}" class="link text-dark">--}}
{{--                  Read More <i class="mdi mdi-arrow-right align-middle"></i>--}}
{{--               </a>--}}
{{--            </div>--}}
{{--         </div>--}}
{{--      </div>--}}
{{--   </div>--}}
{{--</div>--}}
