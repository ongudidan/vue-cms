@extends('website.index')

@section('content')
   @include('website.shared.page-banner', ['title' => $page->title])

   <section class="section">
      <div class="container">
         <div class="row">
            <div class="col-12">
               <p>This page is blank</p>
            </div>
         </div>
      </div>
   </section>

@endsection
