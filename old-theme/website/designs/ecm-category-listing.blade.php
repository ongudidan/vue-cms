<div class="col-12 mt-4">
   <div class="row g-4">
      @php
      $categories = $ecmCategories->filter(function($category) {
          return $category->media->isNotEmpty();
      })
      @endphp
      @foreach($categories->take(6) as $category)
         <div class="col-md-6 col-12 mx-auto">
            <a href="{{ route('ecm.category.show', $category->slug) }}"
               class="position-relative d-block overflow-hidden">
               <div class="bg-overlay-gray"></div>

               <img src="{{ $category->media[0]->original_url ?? asset('website/dummy_1266x749.jpg') }}"
                    alt="{{ $category->slug }}"
                    class="img-fluid w-100"
                    style="object-fit: cover; min-height: 300px; max-height: 700px;">

               <div class="position-absolute top-50 start-50 translate-middle text-center">
                  <p class="text-white text-center mb-0 fw-bold font-bold fs-3">{{ $category->name }}</p>
               </div>
            </a>
         </div>
      @endforeach
   </div>
</div>
