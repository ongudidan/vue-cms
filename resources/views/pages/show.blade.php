@extends($layout)

@section('content')
<div class="page-content">
    @if($page->title)
    <h1 class="page-title">{{ $page->title }}</h1>
    @endif

    @if($page->description)
    <div class="page-description">
        {{ $page->description }}
    </div>
    @endif

    <div class="page-sections">
        @foreach($sections as $sectionHtml)
        {!! $sectionHtml !!}
        @endforeach
    </div>
</div>
@endsection