@extends('website.index')

@push('meta_tags')
   {!! SEOTools::generate() !!}
@endpush

@push('styles')
   <link href="{{ asset('/website/css/tobii.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
{{--   @include('website.shared.page-banner', ['title' => $blog->title])--}}

   <section class="bg-half-170" style="background: url({{$blog->media[0]->original_url ?? asset('website/dummy_800x600.jpg')}}) center;">
      <div class="bg-overlay bg-gradient-overlay"></div>
      <div @class([
             $customisation->section_width_style ?? 'container',
             'w__' . ($customisation->section_width ?? '100')
          ])
      >
         <div class="row mt-5 justify-content-center">
            <div class="col-lg-10">
               <div class="title-heading text-center">
                  <h4 class="heading text-white title-dark">{{ $blog->title }}</h4>

                  <ul class="list-inline">
                     <li class="list-inline-item me-3"><i class="uil uil-user text-white h5 mb-0"></i>
                        <a href="javascript:void(0)" class="text-white-50 h6">
                           {{ $blog->user?->name }}
                        </a>
                     </li>
                     <li class="list-inline-item text-white-50 h6 me-3">
                        <i class="uil uil-calender h5 text-white title-dark"></i>{{ \Carbon\Carbon::parse($blog->created_at)->format('D, d M Y') }}
                     </li>
                     <li class="list-inline-item text-white-50 h6"><i class="uil uil-clock h5 text-white title-dark"></i> 8 min read</li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </section>

<section class="section">
   <div @class([
             $customisation->section_width_style ?? 'container',
             'w__' . ($customisation->section_width ?? '100')
          ])
   >
      <div class="row justify-content-center">
         <div class="col-lg-10">
            <div class="features-absolute shadow bg-white p-4 rounded">
               <div class="row">
                  <div class="col-12">
                     <div class="text-muted">
                        {!! $blog->details !!}
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
@endsection
