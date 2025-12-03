<!DOCTYPE html>
<html lang="en">
<head>
   <!--Meta Tags-->
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="csrf-token" content="{{ csrf_token() }}">
   @stack('meta_tags')

   <!--Favicons-->
   <link rel="shortcut icon" type="image/x-icon" href="{{ $favicon ?? '' }}" />

   <!-- CORE CSS -->
   <link rel="stylesheet" href="{{ asset('website/css/bootstrap.min.css') }}">
   <link rel="stylesheet" href="{{ asset('website/css/aos.css') }}">
   <link rel="stylesheet" href="{{ asset('website/css/tiny-slider.css') }}">
   <link rel="stylesheet" href="{{ asset('website/css/owl.carousel.min.css') }}">
   <link rel="stylesheet" href="{{ asset('website/css/owl.theme.default.min.css') }}">
   <link rel="stylesheet" href="{{ asset('website/css/materialdesignicons.min.css') }}">
   @stack('styles')
   <link href="https://unicons.iconscout.com/release/v3.0.6/css/line.css" rel="stylesheet" />
   <link href="{{ asset('/website/css/tobii.min.css') }}" rel="stylesheet" type="text/css" />
   <link rel="stylesheet" href="{{ asset('website/css/toastr.min.css') }}">
   <link rel="stylesheet" href="{{ asset('website/css/tabler-icons.min.css') }}">
   <link rel="stylesheet" href="{{ asset('website/css/default.css') }}">
   <link rel="stylesheet" href="{{ asset('website/css/styles.css') }}">
   <link rel="stylesheet" href="{{ asset('website/css/custom.css') }}">

   <style>
      :root {
         --ecbz-primary: {{ $customisation->primary_color ?? '#163925' }};
         --ecbz-primary-rgb: {{ $customisation->primary_color_rgb ?? '0, 119, 109' }};
         --ecbz-primary-light: {{ $customisation->primary_color_light ?? '#00776d' }};
         --ecbz-primary-light-rgb: {{ $customisation->primary_color_light_rgb ?? 'rgb(0, 119, 109)' }};
         --ecbz-secondary: {{ $customisation->secondary_color ?? 'rgb(0, 119, 109)' }};
         --ecbz-secondary-rgb: {{ $customisation->secondary_color_rgb ?? 'rgb(0, 119, 109)' }};
         --ecbz-secondary-light: {{ $customisation->secondary_color_light ?? 'rgb(0, 119, 109)' }};
         --ecbz-secondary-light-rgb: {{ $customisation->secondary_color_light_rgb ?? 'rgb(0, 119, 109)' }};
      }
   </style>
</head>
<body data-bs-spy="scroll" data-bs-target="#navbar" data-bs-offset="60" >
@include('website.landing-page.header')
@yield('content')
@include("website.shared.footer")
<button onclick="topFunction()" id="back-to-top" class="back-to-top rounded-pill">
   <i class="mdi mdi-arrow-up"></i>
</button>

<!--Custom js-->
<script src="{{ asset('website/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('website/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('website/js/aos.js') }}"></script>
<script src="{{ asset('website/js/tiny-slider.js') }}"></script>
<script src="{{ asset('website/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('website/js/toastr.min.js') }}"></script>
<script src="{{ asset('website/js/shuffle.min.js') }}"></script>
<script src="{{ asset('website/js/tobii.min.js') }}"></script>
@stack('scripts')
<script src="{{ asset('website/js/custom.js') }}"></script>
</body>
</html>
