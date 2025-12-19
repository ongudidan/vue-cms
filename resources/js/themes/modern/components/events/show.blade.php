@extends($layout)

@section('content')
    <div class="min-h-screen bg-gray-50 pt-12 pb-24">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <nav class="flex mb-8 text-sm text-gray-500 overflow-x-auto whitespace-nowrap" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li><a href="/" class="hover:text-primary transition">Home</a></li>
                    <li class="flex items-center space-x-2">
                        <i data-feather="chevron-right" class="w-4 h-4"></i>
                        <a href="/events" class="hover:text-primary transition">Events</a>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i data-feather="chevron-right" class="w-4 h-4"></i>
                        <span
                            class="text-gray-900 font-medium truncate max-w-[200px] sm:max-w-md">{{ $event->title }}</span>
                    </li>
                </ol>
            </nav>

            <article class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden" data-aos="fade-up">
                <!-- Header/Hero -->
                <div class="relative min-h-[400px] flex items-end">
                    @if($event->media && $event->media->count() > 0)
                        <img src="/media-file/{{ $event->media->first()->file_path }}" alt="{{ $event->title }}"
                            class="absolute inset-0 w-full h-full object-cover">
                    @else
                        <div class="absolute inset-0 bg-gradient-to-br from-primary to-indigo-600"></div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>

                    <div class="relative p-8 md:p-12 w-full">
                        <div class="flex flex-wrap gap-3 mb-6">
                            <span
                                class="px-4 py-1.5 bg-white/20 backdrop-blur-md text-white text-xs font-bold rounded-full uppercase tracking-widest border border-white/30">
                                Upcoming Event
                            </span>
                            @if($event->location)
                                <span
                                    class="px-3 py-1 bg-primary text-white text-xs font-bold rounded-full uppercase flex items-center">
                                    <i data-feather="map-pin" class="w-3 h-3 mr-1"></i>
                                    {{ $event->location }}
                                </span>
                            @endif
                        </div>
                        <h1 class="text-3xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight">
                            {{ $event->title }}
                        </h1>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3">
                    <!-- Content Area -->
                    <div class="lg:col-span-2 p-8 md:p-12">
                        <div class="prose prose-lg prose-primary max-w-none text-gray-700">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6">About the Event</h3>
                            {!! nl2br(e($event->details)) !!}
                        </div>

                        @if($event->media && $event->media->count() > 1)
                            <div class="mt-12">
                                <h3 class="text-xl font-bold text-gray-900 mb-6 uppercase tracking-widest text-sm">Event
                                    Highlights</h3>
                                <div class="grid grid-cols-2 gap-4">
                                    @foreach($event->media->slice(1) as $image)
                                        <div class="aspect-square rounded-2xl overflow-hidden shadow-sm">
                                            <img src="/media-file/{{ $image->file_path }}" alt="{{ $event->title }}"
                                                class="w-full h-full object-cover">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Logistics Sidebar -->
                    <div class="bg-gray-50/50 p-8 md:p-12 border-l border-gray-100">
                        <div class="space-y-8 sticky top-24">
                            <div class="flex items-start">
                                <div class="p-3 bg-white rounded-2xl shadow-sm text-primary mr-4">
                                    <i data-feather="calendar" class="w-6 h-6"></i>
                                </div>
                                <div>
                                    <span class="text-xs font-bold text-gray-400 uppercase">When</span>
                                    <p class="text-gray-900 font-semibold">
                                        {{ $event->date ? \Carbon\Carbon::parse($event->date)->format('l, F d, Y') : 'TBA' }}
                                    </p>
                                    <p class="text-gray-500 text-sm">Starts at 09:00 AM</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="p-3 bg-white rounded-2xl shadow-sm text-primary mr-4">
                                    <i data-feather="map-pin" class="w-6 h-6"></i>
                                </div>
                                <div>
                                    <span class="text-xs font-bold text-gray-400 uppercase">Where</span>
                                    <p class="text-gray-900 font-semibold">{{ $event->location ?? 'To be announced' }}</p>
                                    @if($event->map_url)
                                        <a href="{{ $event->map_url }}" target="_blank"
                                            class="text-primary text-sm hover:underline mt-1 inline-block">View on Google
                                            Maps</a>
                                    @endif
                                </div>
                            </div>

                            @if($event->hosted_by)
                                <div class="flex items-start">
                                    <div class="p-3 bg-white rounded-2xl shadow-sm text-primary mr-4">
                                        <i data-feather="user" class="w-6 h-6"></i>
                                    </div>
                                    <div>
                                        <span class="text-xs font-bold text-gray-400 uppercase">Host</span>
                                        <p class="text-gray-900 font-semibold">{{ $event->hosted_by }}</p>
                                    </div>
                                </div>
                            @endif

                            <div class="pt-8">
                                <button
                                    class="w-full py-4 bg-gray-900 text-white font-bold rounded-2xl hover:bg-black transition shadow-xl flex items-center justify-center group uppercase tracking-widest text-sm">
                                    Register Now
                                    <i data-feather="arrow-right"
                                        class="ml-2 w-4 h-4 group-hover:translate-x-1 transition"></i>
                                </button>
                                <p class="text-center text-xs text-gray-400 mt-4 italic font-medium">Limited spots
                                    available!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </div>
@endsection