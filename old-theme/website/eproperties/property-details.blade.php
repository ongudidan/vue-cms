@extends('website.index')

@push('meta_tags')
   {!! SEOTools::generate() !!}
@endpush

@push('styles')
   <link href="{{ asset('/website/css/tobii.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
   @include('website.shared.page-banner', ['title' => $property->title,])

   <section class="section property-detail py-10">
      <div @class([
             $customisation->section_width_style ?? 'container',
             'w__' . ($customisation->section_width ?? '100')
          ])
      >
         <div class="row gx-5">
            <!-- Left Column -->
            <div class="col-lg-8 col-12 mb-3">
               <div class="property-header mb-4">
                  <h4 class="title mb-0">{{ $property->title }}</h4>
                  <p class="property-location">{{ $property->details->city ?? '' }}, {{ $property->details->country ?? '' }}</p>
                  @if($property->price > 0)
                  <div class="property-price">{{ $property->currency->symbol }} {{ number_format($property->price ?? 0) }}</div>
                  @endif
               </div>

               <!-- Gallery -->
               <div class="mb-4">
               @if(isset($gallery))
                  <div class="property-gallery-{{$property->id}}">
                     @foreach($gallery as $media)
                        <div class="tiny-slide">
                           <img src="{{ $media->original_url ?? asset('website/dummy_450x450.jpg') }}" alt=""
                                class="img-fluid rounded" style="max-height:">
                        </div>
                     @endforeach
                  </div>
               @else
                  <img src="{{ asset('website/dummy_450x450.jpg') }}" class="img-fluid rounded" alt="">
               @endif
               </div>

               <!-- Description -->
               <div class=" mb-4">
                  <h4 class="fw-semibold">Property Description</h4>
                  <div class="text-muted details">
                     {!! $property->description ?? '' !!}
                  </div>
               </div>

               <!-- Features -->
               <div class="mb-4">
                  <h4 class="fw-semibold">Property Features</h4>
                  <ul class="list-unstyled row gx-1">
                     <li class="col-6 col-md-5 me-3 px-2 py-3 border-bottom"><span>Bedrooms: </span><span class="text-muted float-end">{{ $property->details->bedrooms ?? '0' }}</span></li>
                     <li class="col-6 col-md-5 me-3 px-2 py-3 border-bottom"><span>Kitchens: </span><span class="text-muted float-end">{{ $property->details->kitchens ?? '0' }}</span></li>
                     <li class="col-6 col-md-5 me-3 px-2 py-3 border-bottom"><span>Bathrooms: </span><span class="text-muted float-end">{{ $property->details->bathrooms ?? '0' }}</span></li>
                     <li class="col-6 col-md-5 me-3 px-2 py-3 border-bottom"><span>Size: </span><span class="text-muted float-end">{{ $property->details->area_size . ' ' . $property->details->area_unit }}</span></li>
                  </ul>
               </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-4 col-12 mb-3">
               <div class="sidebar sticky-bar">
                  <div class="widget bg-light">
                     <div class="rounded p-4 rounded shadow-sm mb-4">
                        <div class="text-center mb-3">
                           <div class="px-3 rounded">
                              <img src="{{ $logo ?? '' }}" alt="" class="py-3" style="max-height:90px;">
                           </div>
                           <div class="agent-name fw-bold mb-3 text-uppercase">{{ $company->name }}</div>
                           <p class="text-muted">Have any questions? Reach out to us and we will answer!</p>
                        </div>

                        <form method="post" id="propertyInquiryForm">
                           <p id="error-msg"></p>
                           <div id="simple-msg"></div>
                           <input type="hidden" name="property_id" value="{{ $property->id }}">
                           <div class="mb-3">
                              <input type="text" class="form-control" placeholder="Full name" name="name" required>
                              <div class="invalid-feedback text-danger"></div>
                           </div>
                           <div class="mb-3">
                              <input type="tel" class="form-control" placeholder="Phone number" name="phone">
                              <div class="invalid-feedback text-danger"></div>
                           </div>
                           <div class="mb-3">
                              <input type="email" class="form-control" placeholder="Email" name="email" required>
                              <div class="invalid-feedback text-danger"></div>
                           </div>
                           <div class="mb-3">
                              <select class="form-control" name="inquiry_type" required>
                                 <option value=""></option>
                                 <option value="viewing">Viewing</option>
                                 <option value="purchase">Purchase</option>
                                 <option value="lease">Lease</option>
                                 <option value="booking">Booking</option>
                                 <option value="general">General</option>
                              </select>
                              <div class="invalid-feedback text-danger"></div>
                           </div>
                           <div class="mb-3">
                              <textarea class="form-control" rows="3" placeholder="Your message" name="message" required></textarea>
                              <div class="invalid-feedback text-danger"></div>
                           </div>
                           <button type="submit" id="submitInquiry" class="btn btn-primary {{ $customisation->button_style ?? '' }} w-100">
                              <span class="btn-text">Send Message</span>
                              <span class="spinner"></span>
                           </button>
                        </form>
                     </div>
                  </div>
               </div>
            </div>

            <div class="col-12 mt-50 mb-3">
               <div class="row">
                  <h4 class="mb-5">Similar Properties</h4>

                  @if($relatedProperties->count() > 0)
                     <div class="tiny-four-item">
                        @foreach($relatedProperties as $property)
                           <div class="col-12">
                              <div class="card h-100 shadow-sm border-0">
                                 <div class="position-relative">
                                    <img
                                       src="{{ $property->getFirstMediaUrl('property-images') ?: asset('website/dummy_1266x749.jpg') }}"
                                       class="card-img-top"
                                       alt="{{ $property->slug }}"
                                       style="height: 250px; object-fit: cover;"
                                    />
                                    @if($property->featured)
                                       <span class="badge bg-warning position-absolute top-0 start-0 m-2">
                                          <i class="bx bx-star"></i> Featured
                                       </span>
                                    @endif
                                    <span class="badge bg-primary position-absolute top-0 end-0 m-2">
                                       {{ $property->listingType->name ?? '' }}
                                    </span>
                                 </div>

                                 <div class="card-body">
                                    <h5 class="card-title">
                                       <a href="{{ route('properties.show', $property->slug) }}" class="card-link">
                                          {{ $property->title }}
                                       </a>
                                    </h5>
                                    <p class="card-text text-muted small mb-0">{{ Str::limit($property->short_description ?? '', 100) }}</p>
                                    <p class="text-muted small mb-1">
                                       <i class="ti ti-pin fs-6 text-black"></i> {{ $property->details->city ?? '' }}
                                       , {{ $property->details->country ?? '' }}
                                    </p>

                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                       @if(!empty($property->details->bedrooms))
                                          <span class="text-muted small">
                                             <i class="ti ti-bed-filled fs-5 text-secondary"></i> {{ $property->details->bedrooms }}
                                          </span>
                                       @endif
                                       @if(!empty($property->details->bathrooms))
                                          <span class="text-muted small">
                                             <i class="ti ti-bath-filled fs-5 text-secondary"></i> {{ $property->details->bathrooms }}
                                          </span>
                                       @endif
                                       @if(!empty($property->details->total_area))
                                          <span class="text-muted small">
                                             {{ $property->details->total_area }} {{ $property->details->area_unit }}
                                          </span>
                                       @endif
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                       <p class="text-dark mb-0">
                                          {{ $property->currency->symbol }} {{ number_format($property->price ?? 0) }}
                                       </p>
                                       <a href="{{ route('properties.show', $property->slug) }}"
                                          class="btn btn-sm btn-primary">View Details</a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        @endforeach
                     </div>
                  @else
                     <div class="text-center py-5">
                        <i class="bx bx-search-alt display-1 text-muted"></i>
                        <h3 class="mt-3">No Properties Found</h3>
                     </div>
                  @endif
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection

@push('scripts')
   <script>
      document.addEventListener("DOMContentLoaded", function() {
         if(document.querySelector('.property-gallery-{{$property->id}}')) {
            tns({
               container: '.property-gallery-{{$property->id}}',
               items: 1,
               controls: false,
               mouseDrag: true,
               loop: true,
               rewind: true,
               autoplay: true,
               autoplayButtonOutput: false,
               autoplayTimeout: 3000,
               navPosition: "bottom",
               controlsText: [
                  '<i class="mdi mdi-chevron-left"></i>',
                  '<i class="mdi mdi-chevron-right"></i>'
               ],
               nav: false,
               speed: 400,
               gutter: 0,
            });
         }
         if(document.querySelector('.tiny-four-item')) {
            tns({
               container: '.tiny-four-item',
               controls: false,
               mouseDrag: true,
               loop: true,
               rewind: true,
               autoplay: true,
               autoplayButtonOutput: false,
               autoplayTimeout: 3000,
               navPosition: "bottom",
               speed: 400,
               gutter: 12,
               nav: true,
               controlsText: [
                  '<i class="mdi mdi-chevron-left"></i>',
                  '<i class="mdi mdi-chevron-right"></i>'
               ],
               responsive: {
                  992: {
                     items: 4
                  },

                  767: {
                     items: 2
                  },

                  320: {
                     items: 1
                  },
               },
            });
         }
      });
   </script>
   <script src="{{ asset('website/js/property-inquiry.js') }}"></script>
@endpush
