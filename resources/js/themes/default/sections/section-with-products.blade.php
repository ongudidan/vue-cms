<section class="section bg-light" id="{{$section->spa_section_id ?? ''}}">
   <div class="container-fluid">
      <div class="row justify-content-center">
         <div class="col-12">
            <div class="filters-group-wrap text-center">
               <div class="filters-group">
                  <ul class="container-filter mb-0 categories-filter list-unstyled filter-options">
                     <li class="list-inline-item categories position-relative active" data-group="all">All</li>
                     @foreach($groupedProducts as $typeName => $items)
                        <li class="list-inline-item categories position-relative" data-group="{{ $typeName }}">{{ $typeName }}</li>
                     @endforeach
                  </ul>
               </div>
            </div>
         </div>
      </div>
      <div id="grid" class="row row-cols-md-2 row-cols-lg-5 mt-4 pt-2">
         @foreach($groupedProducts as $typeName => $items)
            @foreach($items as $index => $row)
               <div class="col spacing picture-item" data-groups='["{{ $typeName }}"]'>
                  <div class="card portfolio portfolio-creative portfolio-primary shadow rounded overflow-hidden">
                     <div class="position-relative">
                        <img src="{{ asset('website/dummy_450x450.jpg') }}" class="img-fluid" alt="">
                        <div class="overlay"></div>

                        <div class="lightbox-icon">
                           <a href="{{ asset('website/dummy_450x450.jpg') }}" class="lightbox text-dark"><i class="mdi mdi-plus"></i></a>
                        </div>
                     </div>
                     <div class="content p-3">
                        <a href="javascript:void(0)" class="text-dark h6 mb-0 d-block title">{{ $row->name }}</a>
                        <small class="fw-normal mb-0">{{ $typeName }}</small>
                     </div>
                  </div>
               </div>
            @endforeach
         @endforeach
      </div>
   </div>
</section>
