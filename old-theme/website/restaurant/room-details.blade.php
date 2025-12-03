@extends('website.index')

@push('meta_tags')
   {!! SEOTools::generate() !!}
@endpush

@push('styles')
   <link href="{{ asset('/website/css/tobii.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
   @include('website.shared.page-banner', ['title' => $room->name])

   <section class="section">
      <div class="container">
         <!-- Gallery -->
         @if(isset($room->media))
         <div id="grid" class="row mb-5">
            @foreach($room->media as $media)
            <div class="col-md-3 col-12 spacing picture-item" data-groups='[{{ $room->slug }}]'>
               <div class="card portfolio portfolio-classic portfolio-primary rounded-0 overflow-hidden">
                  <div class="card-img position-relative">
                     <img src="{{ $media->original_url ?? asset('website/dummy_450x450.jpg') }}" class="img-fluid" alt="">
                     <div class="card-overlay"></div>

                     <div class="pop-icon">
                        <a href="{{ $media->original_url ?? asset('website/dummy_450x450.jpg') }}" class="btn btn-pills btn-icon lightbox"><i class="uil uil-search"></i></a>
                     </div>
                  </div>
               </div>
            </div>
            @endforeach
         </div>
         @endif
         <div class="row gx-5">
            <div class="col-12 mb-3">
               <div class="property-header mb-4">
                  <h4 class="title">{{ $room->name }}</h4>
                  <div class="d-flex gap-3 mb-3">
                     <span class="badge bg-light text-dark align-content-center justify-content-start">
                         <i class="ti ti-users-group fs-3 text-primary me-2"></i>
                        <span class="">Up to {{$room->capacity}} guest(s)</span>
                     </span>
                     @if($room->area_sqm)
                     <span class="badge bg-light text-dark">
                        <i class="ti ti-ruler fs-3 text-primary me-2"></i>
                        <span class="">{{$room->area_sqm}} m²</span>
                     </span>
                     @endif
                  </div>
                  @if($room->price_per_day > 0)
                     <div class="h6"> <span class="text-muted">Price Per Day: </span>Kshs. {{ number_format($room->price_per_day ?? 0) }}</div>
                  @endif
               </div>

               <!-- Description -->
               <div class=" mb-4">
                  <h4 class="fw-semibold">Room Description</h4>
                  <div class="text-dark details">
                     {!! $room->description ?? '' !!}
                  </div>
               </div>

               <!-- Features -->
               <div class="mb-4">
                  <h4 class="fw-semibold">Amenities</h4>
                  <div class="mb-3">
                     @foreach($room->amenities as $amenity)
                        <i class="mdi {{ $amenity->icon ?? 'mdi mdi-check-circle' }} text-primary me-5 fs-1"
                           title="{{$amenity->name}}"></i>
                     @endforeach
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection
