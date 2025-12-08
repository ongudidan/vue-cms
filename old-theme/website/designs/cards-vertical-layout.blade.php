@foreach($section->section_cards as $key => $card)
   <div class="col-lg-4 col-md-6 mb-3" data-aos="zoom-in-up" data-aos-duration="1000" data-aos-delay="{{ ($key + 1) * 100 }}">
      <div class="card p-4 rounded features features-classic feature-primary h-100">
         <div class="fea-icon rounded bg-light shadow icon">
            <i class="mdi {{ $card->icon ?? '' }} h1 mb-0 text-secondary"></i>
         </div>
         <div class="content text-start mt-4">
            <h5 class="title title-shadow-none">{{ $card->title }}</h5>

            <div class="details mt-3">
               {!! $card->details !!}
            </div>
         </div>
      </div>
   </div>
@endforeach
