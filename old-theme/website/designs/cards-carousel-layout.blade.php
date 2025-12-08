<div class="section-card-slider-{{$section->id}} d-flex flex-row">
@foreach($section->section_cards as $key => $card)
   <div class="col-lg-4 col-md-6 my-3 me-1 tiny-slide h-100" data-aos="zoom-in-up" data-aos-duration="1000" data-aos-delay="{{ ($key + 1) * 400 }}">
      <div class="card p-4 rounded features features-classic feature-primary">
         <div class="fea-icon rounded bg-light shadow icon">
            <i class="mdi {{ $card->icon ?? '' }} h1 mb-0 text-secondary"></i>
         </div>
         <div class="content text-start mt-4">
            <h5 class="title title-shadow-none">{{ $card->title }}</h5>

            <div class="mt-3 details">
               {!! $card->details !!}
            </div>
         </div>
      </div>
   </div>
@endforeach
</div>

@push('scripts')
<script>
   const container =document.querySelector(".section-card-slider-{{$section->id}}");
   if (container) {
      tns({
         container: container,
         controls: false,
         mouseDrag: true,
         loop: true,
         rewind: false,
         autoplay: true,
         autoplayButtonOutput: false,
         autoplayHoverPause: true,
         autoplayTimeout: 3000,
         navPosition: "bottom",
         nav: false,
         speed: 400,
         gutter: 12,
         gutterLeft: 0,
         responsive: {
            992: { items: 3 },
            767: { items: 2 },
            320: { items: 1 },
         },
      });
   }
</script>
@endpush
