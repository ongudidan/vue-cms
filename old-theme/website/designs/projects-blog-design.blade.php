<div class="col-lg-4">
   <ul class="nav nav-pills nav-justified flex-column bg-transparent mb-0" id="projectsTabs" role="tablist">
      @foreach($projects->take(4) as $key => $project)
      <li class="nav-item mb-3" data-aos="fade-right" data-aos-duration="1800" data-aos-delay="{{ ($key + 1) * 400 }}">
         <a class="nav-link rounded shadow @if($key === 0) active @endif" id="{{$key}}" data-bs-toggle="pill" href="#project-{{$key}}" role="tab"
            aria-controls="project-{{$key }}" aria-selected="{{ $key === 0 ? 'true' : 'false' }}">
            <div class="text-start py-2 px-3">
               <h5>{{ $project->title }}</h5>
               <div class="mb-0 details tab-para">
                  {!! Str::words($project->details, 7) !!}
               </div>
            </div>
         </a>
      </li>
      @endforeach
   </ul>
</div>

<div class="col-lg-8 mt-4 pt-2 mt-lg-0 pt-lg-0">
   <div class="tab-content" id="pills-tabContent" data-aos="fade-up" data-aos-duration="1800" data-aos-delay="400">
      @foreach($projects->take(4) as $key => $project)
         <div class="tab-pane fade @if($key === 0) show active @endif" id="project-{{$key}}" role="tabpanel" aria-labelledby="tab-{{$key}}">
            <div class="card blog blog-image blog-primary shadow rounded overflow-hidden">
               <div class="card-img">
                  <img src="{{ $project->media[0]->original_url ?? asset('website/dummy_800x600.jpg') }}" alt="{{$project->slug}}"
                       class="img-fluid">
                  <div class="card-overlay"></div>

                  @if($project->category)
                  <div class="position-absolute top-0 start-0 mt-3 ms-4">
                     <a href="javascript:void(0)" class="badge text-bg-light">{{ $project->category->name }}</a>
                  </div>
                  @endif
               </div>
               <div class="content px-4">
                  <a href="{{ route('projects.show', $project->slug) }}" class="h5 fw-semibold title d-block mb-0 text-dark">
                     {{ $project->title }}
                  </a>

                  <div class="d-flex author align-items-center mt-3">
                     <div class="para-desc text-white mb-0 details">
                        {!! Str::words($project->details, 50) !!}
                     </div>
                  </div>
               </div>
            </div>
         </div>
      @endforeach
   </div>
</div>
