@push('styles')
   <link href="{{ asset('/website/css/tobii.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

<div class="row justify-content-center">
   <div class="col-12">
      <div class="filters-group-wrap text-center">
         <div class="filters-group">
            <ul class="container-filter mb-0 categories-filter list-unstyled filter-options">
               <li class="list-inline-item categories position-relative active" data-group="all">All</li>
               @foreach($groupedEvents as $categoryName => $items)
                  <li class="list-inline-item categories position-relative" data-group="{{ $categoryName }}">{{ $categoryName }}</li>
               @endforeach
            </ul>
         </div>
      </div>
   </div>
</div>
<div id="grid" class="row mt-4 pt-2 shuffle">
   @foreach($groupedEvents as $categoryName => $items)
      @foreach($items as $index => $event)
         <div class="col-lg-4 col-md-4 col-12 spacing picture-item" data-groups='["{{ $categoryName }}"]'>
            <div class="card portfolio portfolio-creative portfolio-primary shadow rounded overflow-hidden">
               <div class="position-relative">
                  <img src="{{ $event->media?->where('collection_name', 'event-image')->first()->original_url ?? asset('website/dummy_450x450.jpg') }}" class="img-fluid" alt="">
                  <div class="overlay"></div>

                  {{--                  <div class="lightbox-icon">--}}
                  {{--                     <a href="{{ $event->media?->where('collection_name', 'event-image')->first()->original_url ?? asset('website/dummy_450x450.jpg') }}" class="lightbox text-dark"><i class="mdi mdi-plus"></i></a>--}}
                  {{--                  </div>--}}
               </div>
               <div class="content p-3">
                  <a href="{{ route('events.show', $event->slug) }}" class="text-dark h6 mb-0 d-block title">{{ $event->title }}</a>
                  <small class="text-muted fw-normal mb-0">{{ $categoryName }}</small>
               </div>
            </div>
         </div>
      @endforeach
   @endforeach
</div>

@push('scripts')
   <script src="{{ asset('website/js/shuffle.min.js') }}"></script>
   <script src="{{ asset('website/js/tobii.min.js') }}"></script>
   <script src="{{ asset('website/js/gallery.init.js') }}"></script>
@endpush
