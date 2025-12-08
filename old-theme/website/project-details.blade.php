@extends('website.index')

@push('meta_tags')
   {!! SEOTools::generate() !!}
@endpush

@push('styles')
   <link href="{{ asset('/website/css/tobii.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
   @include('website.shared.page-banner', ['title' => $project->title])

   <section class="section">
      <div @class([
             $customisation->section_width_style ?? 'container',
             'w__' . ($customisation->section_width ?? '100')
          ])
      >
         <div class="row">
            <div class="col-12">
               <div class="tiny-single-item">
                  <div class="tiny-slide">
                     <img src="{{ $project->media[0]->original_url ?? asset('website/images/portfolio/single01.jpg') }}"  alt="{{ $project->slug }}"
                          class="img-fluid w-100" style="height:500px;">
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="mt-30 mt-60" @class([
             $customisation->section_width_style ?? 'container',
             'w__' . ($customisation->section_width ?? '100')
          ])
      >
         <div class="row">
            <div class="col-lg-8 col-md-6">
               <div class="section-title me-md-4">
                  <h4 class="title mb-4">{{ $project->title }}</h4>
                  <div class="text-muted details">{!! $project->details !!}</div>
               </div>
            </div>

            <div class="col-lg-4 col-md-6 mt-4 pt-2 mt-sm-0 pt-sm-0">
               <div class="sidebar sticky-bar">
                  <div class="widget">
                     <h6 class="widget-title font-weight-bold pt-2 pb-2 shadow bg-light rounded text-center">
                        Other Projects
                     </h6>
                     <div class="my-4">
                        @foreach($otherProjects as $key => $item)
                           <div class="d-flex align-items-center mb-3">
                              <img src="{{ $item->media[0]->original_url ?? asset('website/dummy_800x600.jpg') }}"
                                   class="avatar avatar-small rounded" style="width: auto;" alt="">
                              <div class="flex-1 ms-3">
                                 <a href="{{ route('projects.show', $item->slug) }}" class="d-block title text-dark">
                                    {{ $item->title }}
                                 </a>
                              </div>
                           </div>
                        @endforeach
                     </div>
                     <h6 class="widget-title font-weight-bold pt-2 pb-2 bg-light rounded text-center">Project Details</h6>

                     <dl class="row mb-0 mt-4">
                        <dt class="col-md-4 fw-medium col-5">Category :</dt>
                        <dd class="col-md-8 col-7 text-muted">{{ $project->category->name ?? '-' }}</dd>

                        <dt class="col-md-4 fw-medium col-5">Date :</dt>
                        <dd class="col-md-8 col-7 text-muted">{{ \Carbon\Carbon::parse($project->created_at)->format('D, d M Y') }}</dd>
                     </dl>
                  </div>

                  <div class="widget mt-4 pt-2 text-center">
                     <h6 class="widget-title font-weight-bold pt-2 pb-2 bg-light rounded">Tags</h6>
                     <div class="tagcloud mt-4">
                        @foreach($project->tags as $tag)
                        <a href="javascript:void(0)" class="rounded text-dark">{{ $tag->name }}</a>
                        @endforeach
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="mt-5" @class([
             $customisation->section_width_style ?? 'container',
             'w__' . ($customisation->section_width ?? '100')
          ])
      >
         <div id="grid" class="row">
            @php
               $projectGallery = $project->media->where('collection_name', 'project-gallery');
            @endphp
            @foreach($projectGallery as $gallery)
            <div class="col-md-3 col-12 spacing picture-item" data-groups='["project-gallery"]'>
               <div class="card portfolio portfolio-classic portfolio-primary rounded overflow-hidden">
                  <div class="card-img position-relative">
                     <img src="{{ $gallery->original_url ?? null }}" class="img-fluid" alt="">
                     <div class="card-overlay"></div>

                     <div class="pop-icon">
                        <a href="{{ $gallery->original_url ?? null }}"
                           data-lightbox="project-gallery" class="btn btn-pills btn-icon lightbox">
                           <i class="uil uil-search"></i>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
            @endforeach
         </div>
      </div>
   </section>
@endsection
