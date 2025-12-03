@push('styles')
   <link href="{{ asset('/website/css/tobii.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@if($section->type === 'section-eproperty' && $section->section_style)
   @include('website.designs.' . $section->section_style, ['section' => $section, 'customisation' => $customisation])
@else
   <section class="section">
      <div @class([
             $customisation->section_width_style ?? 'container',
             'w__' . ($customisation->section_width ?? '100')
          ])
      >
      </div>
   </section>
@endif
