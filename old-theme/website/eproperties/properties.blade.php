@extends('website.index')

@push('meta_tags')
   {!! SEOTools::generate() !!}
@endpush

@section('content')
   @include('website.shared.page-banner', ['title' => $page->title])

   <section class="section">
      <div @class([
             $customisation->section_width_style ?? 'container',
             'w__' . ($customisation->section_width ?? '100')
          ])
      >
         <div class="row">
            <div class="col-md-8 col-12">
               <div class="row">
                  @foreach($properties as $property)
                  <div class="col-12">
                     <div class="card blog blog-primary shadow rounded overflow-hidden mb-4">
                        <div class="row align-items-center g-0">
                           <div class="col-md-6">
                              <div class="image card-img position-relative overflow-hidden">
                                 <img src="{{ $property->getFirstMediaUrl('property-images') ?: asset('website/dummy_1266x749.jpg') }}"
                                      class="img-fluid" alt="{{$property->slug}}"
                                      style="height: 250px; object-fit: cover;"
                                 >
                                 <div class="card-overlay"></div>
                                 @if($property->featured)
                                 <div class="blog-tag">
                                    <a href="javascript:void(0)" class="badge text-bg-light">
                                       <i class="bx bx-star me-1"></i> Featured
                                    </a>
                                 </div>
                                 @endif
                              </div>
                           </div>

                           <div class="col-md-6">
                              <div class="card-body content">
                                 <a href="{{ route('properties.show', $property->slug) }}" class="h5 title text-dark d-block mb-0">
                                    {{ $property->title }}
                                 </a>
                                 <div class="text-muted mt-2 mb-2 details">{{ Str::limit($property->short_description ?? '', 100) }}</div>
                                 <p class="text-muted small mb-1">
                                    <i class="ti ti-pin fs-6 text-black"></i> {{ $property->details->city ?? '' }}
                                    , {{ $property->details->country ?? '' }}
                                 </p>

                                 <div class="d-flex justify-content-between align-items-center mb-3">
                                    @if(!empty($property->details->bedrooms))
                                       <span class="text-muted small"><i class="ti ti-bed-filled fs-5 text-secondary"></i> {{ $property->details->bedrooms ?? 0 }}</span>
                                    @endif
                                    @if(!empty($property->details->bathrooms))
                                       <span class="text-muted small"><i class="ti ti-bath-filled fs-5 text-secondary"></i> {{ $property->details->bathrooms ?? 0 }}</span>
                                    @endif
                                    @if(!empty($property->details->total_area))
                                       <span
                                          class="text-muted small">{{ $property->details->total_area ?? '' }} {{ $property->details->area_unit }}</span>
                                    @endif
                                 </div>

                                 <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="text-primary mb-0">
                                       {{ $property->currency->symbol }} {{ number_format($property->price) }}
                                    </h4>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  @endforeach
               </div>
            </div>
            <div class="col-md-4 col-12">
               <div class="sidebar sticky-bar">
                  <div class="widget bg-light">
                     <div class="rounded p-4 rounded shadow-sm mb-4">
                        <form action="{{ route('properties.search') }}" method="GET">
                           <div class="mb-3 form-group">
                              <label class="form-label">Search</label>
                              <input type="text" name="search" class="form-control" placeholder="Search by title, location..."
                                 value="{{ request('search') }}"
                              />
                           </div>
                           <div class="mb-3 form-group">
                              <label class="form-label">Property Type</label>
                              <select name="property_type_id" class="form-select">
                                 <option value="">All Types</option>
                                 @foreach($propertyTypes as $type)
                                    <option value="{{ $type->id }}" {{ request('property_type_id') == $type->id ? 'selected' : '' }}>
                                       {{ $type->name }}
                                    </option>
                                 @endforeach
                              </select>
                           </div>
                           <div class="mb-3 form-group">
                              <label class="form-label">Category</label>
                              <select name="property_category_id" class="form-select">
                                 <option value="">All Categories</option>
                                 @foreach($propertyCategories as $category)
                                    <option value="{{ $category->id }}" {{ request('property_category_id') == $category->id ? 'selected' : '' }}>
                                       {{ $category->name }}
                                    </option>
                                 @endforeach
                              </select>
                           </div>
                           <div class="mb-3 form-group">
                              <label class="form-label">Listing Type</label>
                              <select name="listing_type_id" class="form-select">
                                 <option value="">All Listings</option>
                                 @foreach($listingTypes as $listing)
                                    <option value="{{ $listing->id }}" {{ request('listing_type_id') == $listing->id ? 'selected' : '' }}>
                                       {{ $listing->name }}
                                    </option>
                                 @endforeach
                              </select>
                           </div>
                           <div class="mb-3 form-group">
                              <label class="form-label">Location</label>
                              <input type="text" name="city" class="form-control" placeholder="City"
                                     value="{{ request('city') }}"
                              />
                           </div>

                           <!-- Submit Button -->
                           <div class="mb-3 form-group">
                              <label class="form-label fw-semibold mb-2 d-none d-lg-block">&nbsp;</label>
                              <button type="submit" class="btn btn-icon btn-sm btn-primary w-100">
                                 <i class="bx bx-search-alt"></i>
                                 <span class="">Search</span>
                              </button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>

            <div class="col-12 mt-50 mb-3">
               <div class="row">
                  <h4 class="mb-5">Featured Properties</h4>

                  @if($featuredProperties->count() > 0)
                     <div class="tiny-three-item">
                        @foreach($featuredProperties as $property)
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
         if(document.querySelector('.tiny-three-item')) {
            tns({
               container: '.tiny-three-item',
               controls: false,
               mouseDrag: true,
               loop: true,
               rewind: true,
               autoplay: true,
               autoplayButtonOutput: false,
               autoplayTimeout: 3000,
               navPosition: "bottom",
               speed: 400,
               gutter: 0,
               nav: false,
               controlsText: [
                  '<i class="mdi mdi-chevron-left"></i>',
                  '<i class="mdi mdi-chevron-right"></i>'
               ],
               responsive: {
                  992: {
                     items: 3
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
@endpush
