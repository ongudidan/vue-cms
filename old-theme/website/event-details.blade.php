@extends('website.index')

@push('meta_tags')
   {!! SEOTools::generate() !!}
@endpush

@section('content')
   @include('website.shared.page-banner', ['title' => $event->title])

   <section class="section">
      <div @class([
             $customisation->section_width_style ?? 'container',
             'w__' . ($customisation->section_width ?? '100')
          ])
      >
         <div class="row">
            <div class="col-lg-4 col-12 mb-3">
               <div class="sidebar sticky-bar">
                  <div class="d-block justify-content-start">
                     <img src="{{ $event->media?->where('collection_name', 'event-image')->first()->original_url ?? asset('website/dummy_450x450.jpg') }}"
                          alt="" class="img-fluid img-cover rounded" style="width:329px;height:329px;">

                     <p class="border-bottom text-muted mt-4 pb-2">Hosted By</p>

                     <div class="d-flex align-items-center pt-2">
                        <img src="{{asset('user-dummy.png')}}" alt="" class="avatar avatar-sm rounded-pill border" style="width:45px;height:45px;">
                        <div class="ms-2">
                           <p class="user d-block mb-0"><a href="javascript:void(0)" class="text-dark">{{ $event->hosted_by ?? '' }}</a></p>
                        </div>
                     </div>
                     <div class="tagcloud mt-4">
                        @foreach($event->tags as $tag)
                           <a href="javascript:void(0)" class="rounded text-dark">{{ $tag->name }}</a>
                        @endforeach
                     </div>
                  </div>
               </div>
            </div>

            <div class="col-lg-8 col-12">
               <div class="d-block justify-content-start">
                  <div class="title-heading mb-3">
                     <h1 class="text-dark">{{ $event->title }}</h1>
                  </div>
                  <div class="d-flex align-items-center mb-3">
                     <div class="px-2 py-0 bg-light border rounded text-center align-content-center justify-content-center">
                        <i class="mdi mdi-calendar fs-4 text-muted"></i>
                     </div>
                     <p class="user d-block mb-0 ms-2 text-muted"><a href="javascript:void(0)" class="text-dark">
                           {{ $event->date ? Carbon\Carbon::parse($event->date)->format('D, d M Y') : '' }}</a></p>
                  </div>
                  <div class="d-flex align-items-center mb-3">
                     <div class="px-2 py-0 bg-light border rounded text-center align-content-center justify-content-center">
                        <i class="mdi mdi-map-marker-outline fs-4 text-muted"></i>
                     </div>
                     <p class="user d-block mb-0 ms-2 text-muted"><a href="javascript:void(0)" class="text-dark">{{ $event->location ?? '' }}</a></p>
                  </div>
                  <p class="border-bottom text-muted pb-2">About Event</p>
                  <div class="details">{!! $event->details !!}</div>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection
