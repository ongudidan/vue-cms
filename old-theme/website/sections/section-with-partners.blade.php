<section class="section partners" id="{{$section->spa_section_id ?? ''}}">
   <div @class([
       $customisation->section_width_style ?? 'container',
       'w__' . ($customisation->section_width ?? '100'), 'mt-5' ])
   >
      <div class="row justify-content-center">
         <div class="col-10">
            <div class="owl-carousel owl-theme">
               @foreach($partners as $key => $partner)
                  <img src="{{ $partner->media[0]->original_url ??asset('/website/images/partner/logo-1.svg') }}" class="img-fluid rounded-0" alt=""
                       data-aos="zoom-up" data-aos-duration="1000" data-aos-delay="{{ ($key + 1) * 200}}">
               @endforeach
            </div>
         </div>
      </div>
   </div>
</section>

@push('scripts')
<script>
   $(document).ready(function(){
      $('.owl-carousel').owlCarousel({
         loop: true,
         margin: 10,
         autoplay: true,
         autoplayTimeout: 2000,
         autoplayHoverPause: true,
         nav: true,
         responsive: {
            0: {
               items: 1
            },
            600: {
               items: 2
            },
            1000: {
               items: 4
            }
         }
      });
   });
</script>
@endpush
