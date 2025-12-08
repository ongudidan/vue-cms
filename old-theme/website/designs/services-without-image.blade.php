@foreach($services->take(3) as $key => $service)
<div class="col-xl-4 col-lg-3 col-md-6 col-12 mb-3" data-aos="zoom-in-up" data-aos-duration="1000" data-aos-delay="{{ ($key + 1) * 200 }}">
   <div class="card p-4 border-0 rounded features features-classic feature-secondary">

      <div class="content my-3 border-bottom">
         <a href="{{ route('services.show', $service->slug) }}" class="title h5">{{ $service->title }}</a>

         <div class="text-muted mt-3">{!! Str::words($service->details, 10) !!}</div>
      </div>

      <a href="{{ route('services.show', $service->slug) }}" class="d-flex align-items-center justify-content-between">
         <span class="fw-medium text-dark">Read More</span>
         <i class="mdi mdi-arrow-right"></i>
      </a>
   </div>
</div>
@endforeach
