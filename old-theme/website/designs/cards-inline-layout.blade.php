@foreach($section->section_cards as $key => $card)
<div class="col-lg-4 col-md-6 text-start mb-3" data-aos="zoom-in-up" data-aos-duration="1000" data-aos-delay="{{ ($key + 1) * 100 }}">
   <div class="features feature-primary border-0 d-flex">
      <div class="fea-icon rounded-circle text-white title-dark p-3">
         <i class="mdi {{ $card->icon ?? '' }} h3 mb-0"></i>
      </div>

      <div class="content flex-1 ms-3">
         <h5 class="title title-shadow-none">{{ $card->title }}</h5>
         <p class="details mt-2">
            {!! $card->details !!}
         </p>
      </div>
   </div>
</div>
@endforeach
