{{--<div class="row">--}}
{{--   @foreach($blogs as $key => $blog)--}}
{{--      <div class="col-lg-6 mb-4 pb-2">--}}
{{--         <div class="card blog blog-primary shadow rounded overflow-hidden">--}}
{{--            <div class="row align-items-center g-0">--}}
{{--               <div class="col-md-6">--}}
{{--                  <div class="image card-img position-relative overflow-hidden" style="height: 300px;">--}}
{{--                     <img src="{{ $blog->media->where('collection_name', 'blog-image')->first()->original_url ?? asset('website/dummy_800x600.jpg') }}"--}}
{{--                          class="img-cover" alt="{{$blog->slug}}">--}}
{{--                     <div class="card-overlay"></div>--}}
{{--                  </div>--}}
{{--               </div>--}}

{{--               <div class="col-md-6">--}}
{{--                  <div class="card-body content">--}}
{{--                     <a href="{{ route('blogs.show', $blog->slug) }}" class="h5 text-dark d-block mb-3">--}}
{{--                        {{ $blog->title }}--}}
{{--                     </a>--}}
{{--                     <div class="text-muted">--}}
{{--                        {!! Str::words($blog->details, 15) !!}--}}
{{--                     </div>--}}
{{--                     --}}{{--                           <a href="{{ route('blogs.show', $blog->slug) }}" class="link text-dark">--}}
{{--                     --}}{{--                              Read More<i class="uil uil-arrow-right align-middle"></i>--}}
{{--                     --}}{{--                           </a>--}}
{{--                  </div>--}}
{{--               </div>--}}
{{--            </div>--}}
{{--         </div>--}}
{{--      </div>--}}
{{--   @endforeach--}}
{{--</div>--}}

<div class="row" id="grid">
   @foreach($blogs as $key => $blog)
   <div class="col-lg-4 col-md-6 mb-4 pb-2 picture-item">
      <div class="card blog blog-image blog-primary shadow rounded overflow-hidden">
         <div class="image card-img">
            <img src="{{$blog->media->where('collection_name', 'blog-image')->first()->original_url ?? asset('website/dummy_800x600.jpg')}}" class="img-cover img-fluid" alt="">
            <div class="card-overlay"></div>

{{--            <div class="position-absolute top-0 start-0 mt-3 ms-4">--}}
{{--               <a href="javascript:void(0)" class="badge text-bg-light">Finance</a>--}}
{{--            </div>--}}
         </div>
         <div class="content px-4">
            <a href="{{ route('blogs.show', $blog->slug) }}" class="h5 title d-block mb-0 text-white title-dark">{{ $blog->title }}</a>

            <div class="d-flex author align-items-center mt-2">
               <img src="{{asset('user-dummy.png')}}" class="avatar avatar-md-sm rounded-pill" alt="">
               <div class="ms-2">
                  <small class="text-white-50 user d-block">{{ $blog->user?->name }}</small>
                  <small class="text-white-50 date">{{ \Carbon\Carbon::parse($blog->created_at)->format('D, d M Y') }}</small>
               </div>
            </div>
         </div>
      </div>
   </div>
   @endforeach
</div>
