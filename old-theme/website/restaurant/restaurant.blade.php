@extends('website.index')

@push('meta_tags')
   {!! SEOTools::generate() !!}
@endpush

@section('content')
   @include('website.shared.page-banner', ['title' => $page->title])

   <section class="section">
      <div class="container-fluid w__80">
         <div class="row">
            <div class="col-md-8 col-12">
               <div class="row">
                  @foreach($rooms as $room)
                     <div class="col-12 mb-4 bg-light">
                        <div class="row">
                           <div class="col-lg-6 ps-0">
                              <div class="img-wrapper">
                                 <img src="{{ $room->getFirstMediaUrl('room-images') ?: asset('website/dummy_1266x749.jpg') }}"
                                      alt="{{$room->slug}}" class="img-fluid"
                                      style="object-fit:cover;object-position:center;display:block;min-height:330px;">
                              </div>
                           </div>
                           <div class="col-lg-6 align-self-center">
                              <div class="mb-3 mt-3">
                                 <a href="{{ route('rooms.show', $room->slug) }}" class="h4 text-dark mb-3 d-block title">
                                    {{ $room->name }}
                                 </a>

                                 <div class="text-muted mt-2 mb-2 details room">
                                    {!! Str::limit($room->description ?? '', 200) !!}
                                 </div>

                                 <div class="d-flex gap-3 mb-3">
                                    <span class="badge bg-white text-dark">
                                        <i class="ti ti-users-group fs-5 text-primary me-2"></i> Up to {{$room->capacity}} guest(s)
                                    </span>
                                    @if($room->area_sqm)
                                    <span class="badge bg-white text-dark">
                                       <i class="ti ti-ruler fs-5 text-primary me-2"></i> {{$room->area_sqm}} m²
                                    </span>
                                    @endif
                                 </div>

                                 <div class="mb-3">
                                    @foreach($room->amenities as $amenity)
                                       <i class="mdi {{ $amenity->icon ?? 'mdi mdi-check-circle' }} text-primary me-1 fs-5"
                                          title="{{$amenity->name}}"></i>
                                    @endforeach
                                 </div>

                                 <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('rooms.show', $room->slug) }}" class="btn btn-sm btn-primary rounded-0">
                                       Read More
                                    </a>
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
                        <div class="text-center mb-3">
                           <div class="px-3 rounded">
                              <img src="{{ $logo ?? '' }}" alt="" class="py-3" style="max-height:90px;">
                           </div>
                        </div>

                        <form action="{{ route('rooms.search') }}" method="GET">
                           <div class="mb-3 form-group">
                              <label class="form-label">Search</label>
                              <input type="text" name="search" class="form-control rounded-0" placeholder="Search..."
                                     value="{{ request('search') }}"
                              />
                           </div>
                           <div class="mb-3 form-group">
                              <label class="form-label">Room Type</label>
                              <select name="room_type_id" class="form-select rounded-0">
                                 <option value=""></option>
                                 @foreach($roomTypes as $type)
                                    <option value="{{$type->id }}">{{$type->name}}</option>
                                 @endforeach
                              </select>
                           </div>
                           <div class="mb-3 form-group">
                              <label class="form-label">Capacity</label>
                              <input type="number" class="form-control rounded-0" name="capacity">
                           </div>
                           <div class="mb-3 form-group">
                              <label class="form-label">Price Per Day</label>
                              <input type="number" class="form-control rounded-0" name="price_per_day">
                           </div>
                           <div class="mb-3 form-group">
                              <label class="form-label">Price Per Hour</label>
                              <input type="number" class="form-control rounded-0" name="price_per_hour">
                           </div>
                           <div class="mb-3 form-group">
                              <label class="form-label">Amenity</label>
                              <select name="amenity_id" class="form-select rounded-0">
                                 <option value=""></option>
                                 @foreach($amenities as $amenity)
                                 <option value="{{$amenity->id }}">{{$amenity->name}}</option>
                                 @endforeach
                              </select>
                           </div>

                           <!-- Submit Button -->
                           <div class="mb-3 form-group">
                              <label class="form-label fw-semibold mb-2 d-none d-lg-block">&nbsp;</label>
                              <button type="submit" class="btn btn-icon btn-sm btn-primary w-100 rounded-0">
                                 <i class="bx bx-search-alt"></i>
                                 <span class="">Search</span>
                              </button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection
