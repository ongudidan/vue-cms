<section class="home-slider-2 align-items-center">
   <div id="heroSectionSlider-{{$section->id}}" class="owl-carousel owl-theme">
      <div class="bg-home-2 d-flex align-items-center section-bg"
           style="max-height: 1200px; min-height: 750px; background:linear-gradient(to right, var(--ecbz-primary),rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)),
           url({{ $section->media[0]->original_url ?? asset('dummy-image.jpg') }}) no-repeat center / cover;height: 100%;">
         <div @class([
             $customisation->section_width_style ?? 'container',
             'w__' . ($customisation->section_width ?? '100') ])
         >
            <div class="row">
               <div class="col-lg-12 text-start">
                  <div class="section-title mt-4">
                     <h6 class="home-subtitle text-wrap text-secondary" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
                        {{ $section->sub_title ?? '' }}
                     </h6>
                     <h3 class="title text-primary" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="800">
                        {{ $section->title ?? '' }}
                     </h3>
                     <div class="text-white para-desc fw-semibold details" data-aos="fade-up" data-aos-duration="1400" data-aos-delay="1000">
                        {!! $section->details !!}
                     </div>
                     @if($section->has_cta_buttons && $section->cta_buttons->isNotEmpty())
                        <div class="mt-4 pt-2" data-aos="fade-right" data-aos-duration="1600" data-aos-delay="1200">
                           @foreach($section->cta_buttons as $button)
                              <a href="{{ url($button->page->slug ?? 'javascript:void(0)') }}" class="btn {{ $button->cta_button_type . ' ' . $customisation->button_style ?? '' }}">
                                 {{ $button->cta_button_text }}
                              </a>
                           @endforeach
                        </div>
                     @endif
                  </div>
               </div>
            </div>
         </div>
      </div>
      @foreach($section->hero_slides as $slide)
      <div class="bg-home-2 d-flex align-items-center section-bg"
           style="max-height: 1200px; min-height: 750px; background:linear-gradient(to right, var(--ecbz-primary), rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)),
           url({{ $slide->media[0]->original_url ?? asset('dummy-image.jpg') }}) no-repeat center / cover;">
         <div class="container">
            <div class="row">
               <div class="col-lg-12 text-start">
                  <div class="section-title mt-4">
                     <h6 class="home-subtitle text-wrap text-secondary" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
                        {{ $slide->sub_title ?? '' }}
                     </h6>
                     <h3 class="title text-primary" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="800">
                        {{ $slide->title ?? '' }}
                     </h3>
                     <div class="text-white fw-semibold para-desc details" data-aos="fade-up" data-aos-duration="1400" data-aos-delay="1000">
                        {!! $slide->details !!}
                     </div>
                     @if($slide->page)
                        <div class="mt-4 pt-2" data-aos="fade-up" data-aos-duration="1600" data-aos-delay="1200">
                           <a href="{{ url($slide->page->slug ?? 'javascript:void(0)') }}" class="btn {{ $slide->cta_button_type . ' ' . $customisation->button_style ?? '' }}">
                              {{ $slide->cta_button_text ?? $slide->page->title }}
                           </a>
                        </div>
                     @endif
                  </div>
               </div>
            </div>
         </div>
      </div>
      @endforeach
   </div>
   @if($restaurantEnabled === 'YES')
      <div class="booking-form-overlay position-absolute w-100">
         @include('website.restaurant.hero-booking-form')
      </div>
   @endif
</section>

@if($epropertyEnabled === 'YES')
<section class="section">
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-lg-12">
            <div class="features-absolute rounded shadow p-md-5 p-4 bg-white">
               <form action="{{ route('properties.search') }}" method="GET">
                  <div class="row g-3">
                     <!-- Search Input -->
                     <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                           <label class="form-label fw-semibold mb-2">
                              <i class="bx bx-search-alt me-1"></i>Search
                           </label>
                           <input
                              type="text"
                              name="search"
                              class="form-control"
                              placeholder="Search by title, location..."
                              value="{{ request('search') }}"
                           />
                        </div>
                     </div>

                     <!-- Property Type -->
                     <div class="col-lg-2 col-md-6">
                        <div class="form-group">
                           <label class="form-label fw-semibold mb-2">
                              <i class="bx bx-buildings me-1"></i>Property Type
                           </label>
                           <select name="property_type_id" class="form-select">
                              <option value="">All Types</option>
                              @foreach($propertyTypes as $type)
                                 <option value="{{ $type->id }}" {{ request('property_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                 </option>
                              @endforeach
                           </select>
                        </div>
                     </div>

                     <!-- Category -->
                     <div class="col-lg-2 col-md-6">
                        <div class="form-group">
                           <label class="form-label fw-semibold mb-2">
                              <i class="bx bx-category me-1"></i>Category
                           </label>
                           <select name="property_category_id" class="form-select">
                              <option value="">All Categories</option>
                              @foreach($propertyCategories as $category)
                                 <option value="{{ $category->id }}" {{ request('property_category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                 </option>
                              @endforeach
                           </select>
                        </div>
                     </div>

                     <!-- Listing Type -->
                     <div class="col-lg-2 col-md-6">
                        <div class="form-group">
                           <label class="form-label fw-semibold mb-2">
                              <i class="bx bx-home-circle me-1"></i>Listing Type
                           </label>
                           <select name="listing_type_id" class="form-select">
                              <option value="">All Listings</option>
                              @foreach($listingTypes as $listing)
                                 <option value="{{ $listing->id }}" {{ request('listing_type_id') == $listing->id ? 'selected' : '' }}>
                                    {{ $listing->name }}
                                 </option>
                              @endforeach
                           </select>
                        </div>
                     </div>

                     <!-- Location -->
                     <div class="col-lg-2 col-md-6">
                        <div class="form-group">
                           <label class="form-label fw-semibold mb-2">
                              <i class="bx bx-map me-1"></i>Location
                           </label>
                           <input
                              type="text"
                              name="city"
                              class="form-control"
                              placeholder="City"
                              value="{{ request('city') }}"
                           />
                        </div>
                     </div>

                     <!-- Submit Button -->
                     <div class="col-lg-1 col-md-12">
                        <div class="form-group">
                           <label class="form-label fw-semibold mb-2 d-none d-lg-block">&nbsp;</label>
                           <button type="submit" class="btn btn-icon btn-sm btn-primary w-100">
                              <i class="bx bx-search-alt"></i>
                              <span class=""><i class="ti ti-search"></i></span>
                           </button>
                        </div>
                     </div>

                     <!-- Advanced Filters Toggle -->
                     <div class="col-12">
                        <button
                           type="button"
                           class="btn btn-sm btn-icon text-decoration-none p-0"
                           data-bs-toggle="collapse"
                           data-bs-target="#advancedFilters"
                        >
                           <i class="bx bx-filter-alt me-1"></i>Advanced Filters
                        </button>
                     </div>

                     <!-- Advanced Filters -->
                     <div class="collapse" id="advancedFilters">
                        <div class="row g-3 mt-2 pt-3 border-top">
                           <!-- Price Range -->
                           <div class="col-lg-3 col-md-6">
                              <label class="form-label fw-semibold mb-2">
                                 <i class="bx bx-dollar me-1"></i>Min Price
                              </label>
                              <input
                                 type="number"
                                 name="min_price"
                                 class="form-control"
                                 placeholder="0"
                                 value="{{ request('min_price') }}"
                              />
                           </div>

                           <div class="col-lg-3 col-md-6">
                              <label class="form-label fw-semibold mb-2">
                                 <i class="bx bx-dollar me-1"></i>Max Price
                              </label>
                              <input
                                 type="number"
                                 name="max_price"
                                 class="form-control"
                                 placeholder="Any"
                                 value="{{ request('max_price') }}"
                              />
                           </div>

                           <!-- Bedrooms -->
                           <div class="col-lg-2 col-md-4">
                              <label class="form-label fw-semibold mb-2">
                                 <i class="bx bx-bed me-1"></i>Bedrooms
                              </label>
                              <select name="bedrooms" class="form-select">
                                 <option value="">Any</option>
                                 <option value="1" {{ request('bedrooms') == '1' ? 'selected' : '' }}>1+</option>
                                 <option value="2" {{ request('bedrooms') == '2' ? 'selected' : '' }}>2+</option>
                                 <option value="3" {{ request('bedrooms') == '3' ? 'selected' : '' }}>3+</option>
                                 <option value="4" {{ request('bedrooms') == '4' ? 'selected' : '' }}>4+</option>
                                 <option value="5" {{ request('bedrooms') == '5' ? 'selected' : '' }}>5+</option>
                              </select>
                           </div>

                           <!-- Bathrooms -->
                           <div class="col-lg-2 col-md-4">
                              <label class="form-label fw-semibold mb-2">
                                 <i class="bx bx-bath me-1"></i>Bathrooms
                              </label>
                              <select name="bathrooms" class="form-select">
                                 <option value="">Any</option>
                                 <option value="1" {{ request('bathrooms') == '1' ? 'selected' : '' }}>1+</option>
                                 <option value="2" {{ request('bathrooms') == '2' ? 'selected' : '' }}>2+</option>
                                 <option value="3" {{ request('bathrooms') == '3' ? 'selected' : '' }}>3+</option>
                                 <option value="4" {{ request('bathrooms') == '4' ? 'selected' : '' }}>4+</option>
                              </select>
                           </div>

                           <!-- Status -->
                           <div class="col-lg-2 col-md-4">
                              <label class="form-label fw-semibold mb-2">
                                 <i class="bx bx-check-circle me-1"></i>Status
                              </label>
                              <select name="status" class="form-select">
                                 <option value="">All</option>
                                 <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                                 <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                 <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Sold</option>
                                 <option value="rented" {{ request('status') == 'rented' ? 'selected' : '' }}>Rented</option>
                              </select>
                           </div>

                           <!-- Featured Only -->
                           <div class="col-lg-12">
                              <div class="form-check">
                                 <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="featured"
                                    value="1"
                                    id="featured"
                                    {{ request('featured') ? 'checked' : '' }}
                                 />
                                 <label class="form-check-label" for="featured">
                                    <i class="bx bx-star text-warning me-1"></i>Featured Properties Only
                                 </label>
                              </div>
                           </div>

                           <!-- Clear Filters -->
                           <div class="col-12">
                              <a href="{{ route('properties.search') }}" class="btn btn-outline-secondary">
                                 <i class="bx bx-reset me-1"></i>Clear All Filters
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</section>
@endif

@push('scripts')
   <script>
      $('#heroSectionSlider-{{$section->id}}').owlCarousel({
         loop: true,
         items: 1,
         margin: 0,
         autoplay: true,
         autoplayTimeout: 6000,
         autoplayHoverPause: true,
         nav: false,
         dots: true,
         // animateOut: 'fadeOut',
         // animateIn: 'fadeIn',
         smartSpeed: 2000 // smooth transition speed
      });
      // heroSection.on('changed.owl.carousel', function(event) {
      //    let currentItem = $('.owl-item', this).eq(event.item.index);
      //    currentItem.find('.title-heading').addAttributes('animate__animated animate__fadeInUp');
      // });
   </script>
@endpush
