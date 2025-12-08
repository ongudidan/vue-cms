@extends('website.index')

@push('meta_tags')
   {!! SEOTools::generate() !!}
@endpush

@section('content')
   @include('website.shared.page-banner', ['title' => 'Property Search Results'])

   <section class="section">
      <div @class([
             $customisation->section_width_style ?? 'container',
             'w__' . ($customisation->section_width ?? '100'), 'py-5'
          ])
      >
         <div class="row mb-4">
            <div class="col-12">
               <h2 class="fw-bold mb-2">Search Results</h2>
               <p class="text-muted">
                  Found {{ $properties->total() }} properties
                  @if(request('search'))
                     matching "{{ request('search') }}"
                  @endif
               </p>
            </div>
         </div>

         <!-- Sort Options -->
         <div class="row mb-4">
            <div class="col-md-6">
               <form method="GET" action="{{ route('properties.search') }}">
                  @foreach(request()->except('sort') as $key => $value)
                     <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                  @endforeach

                  <div class="d-flex align-items-center">
                     <label class="me-2 text-nowrap">Sort by:</label>
                     <select name="sort" class="form-select w-auto" onchange="this.form.submit()">
                        <option value=""></option>
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to
                           High
                        </option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High
                           to Low
                        </option>
                     </select>
                  </div>
               </form>
            </div>
         </div>

         <!-- Results Grid -->
         @if($properties->count() > 0)
            <div class="row g-4">
               @foreach($properties as $property)
                  <div class="col-lg-4 col-md-6">
                     <div class="card h-100 shadow-sm border-0">
                        <div class="position-relative">
                           <img
                              src="{{ $property->getFirstMediaUrl('property-images') ?: asset('website/dummy_1266x749.jpg') }}"
                              class="card-img-top"
                              alt="{{ $property->title }}"
                              style="height: 250px; object-fit: cover;"
                           />
                           @if($property->featured)
                              <span class="badge bg-warning position-absolute top-0 start-0 m-2">
                                    <i class="bx bx-star"></i> Featured
                                </span>
                           @endif
                           @if($property->listingType)
                           <span class="badge bg-primary position-absolute top-0 end-0 m-2">
                                {{ $property->listingType->name }}
                            </span>
                           @endif
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
                              <a href="{{ route('properties.show', $property->slug) }}" class="btn btn-sm btn-primary">View
                                 Details
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
               @endforeach
            </div>

            <!-- Pagination -->
            <div class="row mt-5">
               <div class="col-12">
                  {{ $properties->links() }}
               </div>
            </div>
         @else
            <div class="text-center py-5">
               <i class="bx bx-search-alt display-1 text-muted"></i>
               <h3 class="mt-3">No Properties Found</h3>
               <p class="text-muted">Try adjusting your search filters</p>
               <a href="{{ route('properties.search') }}" class="btn btn-primary">Clear Filters</a>
            </div>
         @endif
      </div>
   </section>
@endsection
