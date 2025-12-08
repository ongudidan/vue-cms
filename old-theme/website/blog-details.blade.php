@extends('website.index')

@push('meta_tags')
   {!! SEOTools::generate() !!}
@endpush

@push('styles')
   <link href="{{ asset('/website/css/tobii.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')

<section class="bg-half-80 bg-gradient">
   <div @class([
             $customisation->section_width_style ?? 'container',
             'w__' . ($customisation->section_width ?? '100')
          ])
   >
      <div class="row justify-content-center">
         <div class="col-lg-10">
            <div class="title-heading">
               <h4 class="heading fw-semibold">{{ $blog->title }}</h4>

               <div class="d-flex mt-4 pb-4 align-items-center justify-content-between">
                  <div class="d-flex author align-items-center">
                     <img src="{{asset('user-dummy.png')}}" alt="" class="avatar avatar-sm rounded-pill border" style="width:45px;height:45px;">
                     <div class="ms-2">
                        <h6 class="user d-block mb-0"><a href="javascript:void(0)" class="text-dark">{{ $blog->user?->name }}</a></h6>
{{--                        <small class="date text-muted mb-0">Content Writer</small>--}}
                     </div>
                  </div>

{{--                  <div>--}}
{{--                     <a href="javascript:void(0)" class="btn btn-primary">Follow</a>--}}
{{--                  </div>--}}
               </div>

               <ul class="list-inline d-flex pt-4 mb-0 border-top justify-content-between">
                     <li class="list-inline-item text-muted h6"><i class="uil uil-calender h5 text-dark me-2"></i>{{ \Carbon\Carbon::parse($blog->created_at)->format('D, d M Y') }}</li>
                  <li class="list-inline-item text-muted h6"><i class="uil uil-clock h5 text-dark me-2"></i> 10 min read</li>
               </ul>
            </div>

            <div class="mt-5">
               <img src="{{$blog->media[0]->original_url ?? asset('website/dummy_800x600.jpg')}}" class="img-fluid rounded shadow" alt="">
            </div>

            <div class="mt-5">
               <div class="text-muted details">{!! $blog->details !!}</div>
            </div>

            <div class="card shadow rounded border-0 mt-5">
               <div class="card-body">
                  <h5 class="card-title mb-0">Related Blogs :</h5>

                  <div class="row">
                     @foreach($otherBlogs->take(2) as $blog)
                        <div class="col-md-6 mt-4 pt-2">
                           <div class="card blog blog-primary shadow rounded overflow-hidden">
                              <div class="image position-relative overflow-hidden">
                                 <img src="{{$blog->media->where('collection_name', 'blog-image')->first()->original_url ?? asset('website/dummy_800x600.jpg')}}" class="img-fluid" alt="">
                              </div>

                              <div class="card-body content">
                                 <a href="{{ route('blogs.show', $blog->slug) }}" class="h5 title text-dark d-block mb-0">
                                    {{ $blog->title }}
                                 </a>
                                 <p class="text-muted mt-2 mb-2">{!! Str::words($blog->details, 15) !!}</p>
                                 <a href="{{ route('blogs.show', $blog->slug) }}" class="link text-dark">
                                    Read More <i class="uil uil-arrow-right align-middle"></i>
                                 </a>
                              </div>
                           </div>
                        </div>
                     @endforeach
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
@endsection
