<div class="col-md-6 col-12">
   <div class="tab-content" id="services-1-tabContent">
      <div class="tab-pane fade show active" id="services-1" role="tabpanel" aria-labelledby="services-1-tab">
         <div class="accordion mt-4 pt-2" id="servicesInFaq-{{$section->id}}">
            @foreach($services as $key => $service)
               @if($loop->even)
               <div class="accordion-item rounded border-0 shadow mb-3" data-aos="zoom-in-up" data-aos-duration="1000" data-aos-delay="{{ $key * 200 }}">
                  <h2 class="accordion-header" id="{{ $service->id }}">
                     <button class="accordion-button border-0 bg-white" type="button" data-bs-toggle="collapse"
                             data-bs-target="#faq-{{ $service->id }}" aria-expanded="true" aria-controls="faq-{{ $service->id }}">
                        {{ $service->title }}
                     </button>
                  </h2>
                  <div id="faq-{{ $service->id }}" class="accordion-collapse border-0 collapse" aria-labelledby="{{ $service->id }}"
                       data-bs-parent="#servicesInFaq-{{$section->id}}">
                     <div class="accordion-body text-muted bg-white">
                        {!!  $service->details !!}
                     </div>
                  </div>
               </div>
               @endif
            @endforeach
         </div>
      </div>
   </div>
</div>

<div class="col-md-6 col-12">
   <div class="tab-content" id="services-2-tabContent">
      <div class="tab-pane fade show active" id="services-2" role="tabpanel" aria-labelledby="services-2-tab">
         <div class="accordion mt-4 pt-2" id="servicesInFaq-{{$section->id}}">
            @foreach($services as $key => $service)
               @if($loop->odd)
               <div class="accordion-item rounded border-0 shadow mb-3" data-aos="zoom-in-up" data-aos-duration="1000" data-aos-delay="{{ $key * 200 }}">
                  <h2 class="accordion-header" id="{{ $service->id }}">
                     <button class="accordion-button border-0 bg-white" type="button" data-bs-toggle="collapse"
                             data-bs-target="#faq-{{ $service->id }}" aria-expanded="true" aria-controls="faq-{{ $service->id }}">
                        {{ $service->title }}
                     </button>
                  </h2>
                  <div id="faq-{{ $service->id }}" class="accordion-collapse border-0 collapse" aria-labelledby="{{ $service->id }}"
                       data-bs-parent="#servicesInFaq-{{$section->id}}">
                     <div class="accordion-body text-muted bg-white">
                        {!!  $service->details !!}
                     </div>
                  </div>
               </div>
               @endif
            @endforeach
         </div>
      </div>
   </div>
</div>
