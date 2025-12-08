<?php
$backgroundImage = $customisation->media?->firstWhere('collection_name', 'banner-image');
?>
<section class="bg-half-170 d-table w-100" style="background: url({{ $backgroundImage ? $backgroundImage->getUrl() : '' }}) no-repeat center / cover;">
   <div class="bg-overlay {{ $customisation->banner_bg ?? 'bg-gradient-overlay' }}"></div>
   <div @class([
       $customisation->section_width_style ?? 'container',
       'w__' . ($customisation->section_width ?? '100') ])
   >
      <div class="row g-0 align-items-center mt-5">
         <div class="col-lg-8 col-md-6">
            <div class="title-heading text-md-start text-center">
               <h5 class="heading fw-semibold mb-0 page-heading text-white title-dark">{{ $title }}</h5>
               @if($page->description)
               <small class="text-white-50 mb-1 fw-medium text-uppercase mx-auto">{!! $page->description !!}</small>
               @endif
            </div>
         </div>

         <div class="col-lg-4 col-md-6 mt-4 mt-sm-0">
            <div class="text-md-end text-center">
               <nav aria-label="breadcrumb" class="d-inline-block">
                  <ul class="breadcrumb breadcrumb-muted mb-0 p-0">
                     <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                     @if(!empty($parent))
                     <li class="breadcrumb-item"><a href="{{ url($parent?->slug ?? '') }}">{{ $page->title }}</a></li>
                     @endif
                     <li class="breadcrumb-item active" aria-current="page">{{ $page->title }}</li>
                  </ul>
               </nav>
            </div>
         </div>
      </div>
   </div>
</section>
