@extends('website.landing-page')

@push('meta_tags')
   {!! SEOTools::generate() !!}
@endpush

@section('content')
@if($sections->isNotEmpty())
   @foreach($sections as $section)
      @php
         $resourceKey = $section->section_type->value;
         $resources = $sectionResources[$resourceKey] ?? [];
      @endphp
      @includeIf('website.sections.' . $section->section_type->value, array_merge(['page' => $page, 'section' => $section, 'customisation' => $customisation], $resources))
   @endforeach
@endif

@endsection
