@php
   $backgroundImage = $section->media?->firstWhere('collection_name', 'section_bg');
@endphp
<section class="section" id="{{$section->spa_section_id ?? ''}}">
   @if($section->section_has_bg)
   <div class="{{ $section->section_background_color ?? '' }}">
      @if($section->section_background_type === 'image-bg')
         <img src="{{ $backgroundImage->getUrl() ?? asset('website/images/backgrounds/T5.jpg') }}" alt="image">
      @endif
   </div>
   @endif
   <div @class([
       $customisation->section_width_style ?? 'container',
       'w__' . ($customisation->section_width ?? '100'), 'mt-5' ])
   >
      <div class="row align-items-center">
         <div class="col-12">
            <div class="section-title text-center mb-4 pb-2">
               @if($section->sub_title)
               <p class="sub-title" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                  {{ $section->sub_title }}
               </p>
               @endif
               @if($section->title)
               <h2 class="title" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                  {{ $section->title }}
               </h2>
               @endif
               @if($section->details)
               <div class="details" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                  {!! $section->details !!}
               </div>
               @endif
            </div>
         </div>
      </div>

      <div class="row">
         @foreach($pricingPlans as $plan)
         <div class="col-lg-4 col-md-6 col-12 mt-4 pt-2">
            <div class="card shadow bg-white p-4 pt-5">
               <div class="text-center">
                  <h4 class="fw-semibold mb-0">{{ $plan->name }}</h4>

                  <div class="d-flex justify-content-center my-4">
                     <span class="price h3 fw-semibold mb-0">KES. {{number_format($plan->price * 0.01, 0, 2)}}</span>
                     @if($plan->billing_period_label)
                     <span class="text-muted align-self-end mb-1">{{ '/' . $plan->billing_period_label }}</span>
                     @endif
                  </div>
                  <p class="text-muted mb-0">{{ $plan->tagline }}</p>
               </div>

               <div class="p-4 mt-4 bg-soft-primary rounded shadow">
                  <h6 class="mb-3">Features:</h6>
                  <ul class="list-unstyled mb-4">
                     @foreach($plan->features as $feature)
                     <li class="text-muted">
                        <span class="{{ $feature->is_included ? 'text-success' : 'text-danger' }} h5 me-1">
                           <i class="align-middle uil {{ $feature->is_included ? 'uil-check-circle' : 'uil-times-circle' }}"></i>
                        </span>
                        {{ $feature->name }}
                     </li>
                     @endforeach
                  </ul>

                  @if($plan->button_type === 'page')
                  <a href="{{ url($plan->page?->slug ?? 'javascript:void(0)') }}" class="btn btn-secondary {{ $customisation->button_style ?? 'default' }}">
                     {{ $plan->button_text }}
                  </a>
                  @else
                  <a href="{{ $plan->button_url ?? 'javascript:void(0)' }}" class="btn btn-secondary {{ $customisation->button_style ?? 'default' }}">
                     {{ $plan->button_text }}
                  </a>
                  @endif
               </div>
            </div>
         </div>
         @endforeach
      </div>
   </div>
</section>
