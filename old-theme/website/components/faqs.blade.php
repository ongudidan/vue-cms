<div class="row">
   <div class="col-12">
      <div class="tab-content" id="pills-tabContent">
         <div class="tab-pane fade show active" id="pills-buying" role="tabpanel" aria-labelledby="pills-buying-tab">
            <div class="accordion mt-4 pt-2" id="frequentlyAskedQuestion">
               @foreach($faqs as $key => $faq)
               <div class="accordion-item rounded border-0 shadow mb-3" data-aos="zoom-in-up" data-aos-duration="1000" data-aos-delay="{{ $key * 200 }}">
                  <h2 class="accordion-header" id="{{ $key }}">
                     <button class="accordion-button border-0 bg-white" type="button" data-bs-toggle="collapse"
                             data-bs-target="#faq-{{ $key }}" aria-expanded="true" aria-controls="faq-{{ $key }}">
                        {{ $faq->question }}
                     </button>
                  </h2>
                  <div id="faq-{{ $key }}" class="accordion-collapse border-0 collapse" aria-labelledby="{{ $key }}"
                       data-bs-parent="#frequentlyAskedQuestion">
                     <div class="accordion-body text-muted bg-white">
                        {{ $faq->answer }}
                     </div>
                  </div>
               </div>
               @endforeach
            </div>
         </div>
      </div>
   </div>
</div>
