@extends('website.index')

@push('meta_tags')
   {!! SEOTools::generate() !!}
@endpush

@push('styles')
   <link href="{{ asset('/website/css/tobii.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
   @include('website.shared.page-banner', ['title' => $service->title])

   <section class="section">
      <div @class([
             $customisation->section_width_style ?? 'container',
             'w__' . ($customisation->section_width ?? '100')
          ])
      >
         <div class="row">
            <div class="col-lg-8 col-md-6">
               <div class="section-title">
                  <img src="{{ $service->media[0]->original_url ?? asset('website/dummy_800x600.jpg') }}" class="img-fluid rounded" alt="">
                  <h4 class="title text-dark mt-4">{{ $service->title }}</h4>
                  <div class="text-muted details mt-4">{!! $service->details !!}</div>
               </div>
            </div>
            <div class="col-lg-4 col-md-6">
               <div class="sidebar sticky-bar">
                  <div class="widget">
                     <div class="rounded p-4 shadow bg-white">
                        <h6 class="widget-title font-weight-bold pt-2 pb-2 shadow bg-light rounded text-center">
                           Other Services
                        </h6>
                        <div class="mt-4">
                           @foreach($otherServices as $key => $item)
                           <div class="d-flex align-items-center mb-3">
                              <img src="{{ $item->media[0]->original_url ?? asset('website/dummy_800x600.jpg') }}"
                                   class="avatar avatar-small rounded" style="width: auto;" alt="">
                              <div class="flex-1 ms-3">
                                 <a href="{{ route('services.show', $item->slug) }}" class="d-block title text-dark">
                                    {{ $item->title }}
                                 </a>
                              </div>
                           </div>
                           @endforeach
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="container mt-5">
         <div id="grid" class="row">
            @php
               $serviceGallery = $service->media->where('collection_name', 'service-gallery');
            @endphp
            @foreach($serviceGallery as $gallery)
               <div class="col-md-3 col-12 spacing picture-item" data-groups='["service-gallery"]'>
                  <div class="card portfolio portfolio-classic portfolio-primary rounded overflow-hidden">
                     <div class="card-img position-relative">
                        <img src="{{ $gallery->original_url ?? null }}" class="img-fluid" alt="">
                        <div class="card-overlay"></div>

                        <div class="pop-icon">
                           <a href="{{ $gallery->original_url ?? null }}"
                              data-lightbox="service-gallery" class="btn btn-pills btn-icon lightbox">
                              <i class="uil uil-search"></i>
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
            @endforeach
         </div>
      </div>
   </section>
@endsection
