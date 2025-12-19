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
                        <a href="/projects" class="hover:text-primary transition">Projects</a>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i data-feather="chevron-right" class="w-4 h-4"></i>
                        <span
                            class="text-gray-900 font-medium truncate max-w-[200px] sm:max-w-md">{{ $project->title }}</span>
                    </li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Image and Details -->
                <div class="lg:col-span-2 space-y-8">
                    <article class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden"
                        data-aos="fade-up">
                        @if($project->media && $project->media->count() > 0)
                            <div class="aspect-video">
                                <img src="/media-file/{{ $project->media->first()->file_path }}" alt="{{ $project->title }}"
                                    class="w-full h-full object-cover">
                            </div>
                        @endif

                        <div class="p-8 md:p-12">
                            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-8 leading-tight">
                                {{ $project->title }}
                            </h1>

                            <div class="prose prose-lg prose-primary max-w-none text-gray-700 leading-relaxed font-light">
                                {!! nl2br(e($project->details)) !!}
                            </div>

                            @if($project->media && $project->media->count() > 1)
                                <div class="mt-12 grid grid-cols-2 gap-4">
                                    @foreach($project->media->slice(1) as $image)
                                        <div class="aspect-square rounded-xl overflow-hidden border border-gray-100">
                                            <img src="/media-file/{{ $image->file_path }}" alt="{{ $project->title }}"
                                                class="w-full h-full object-cover hover:scale-110 transition duration-700">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </article>
                </div>

                <!-- Right Column: Sidebar Info -->
                <div class="lg:col-span-1 space-y-8">
                    <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 sticky top-24"
                        data-aos="fade-left">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 uppercase tracking-wider">Project Info</h3>

                        <div class="space-y-6">
                            @if($project->status)
                                <div>
                                    <span class="text-xs font-semibold text-gray-400 uppercase">Status</span>
                                    <div class="mt-1">
                                        <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">
                                            {{ $project->status }}
                                        </span>
                                    </div>
                                </div>
                            @endif

                            @if($project->tags)
                                <div>
                                    <span class="text-xs font-semibold text-gray-400 uppercase">Category</span>
                                    <div class="flex flex-wrap gap-2 mt-2">
                                        @php
                                            $tags = is_array($project->tags) ? $project->tags : explode(',', $project->tags);
                                        @endphp
                                        @foreach($tags as $tag)
                                            <span
                                                class="px-2 py-1 bg-gray-100 text-gray-600 text-[10px] font-bold rounded uppercase">
                                                {{ trim($tag) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="pt-6 border-t border-gray-100">
                                <a href="/contact"
                                    class="w-full inline-flex items-center justify-center px-6 py-3 bg-primary text-white font-bold rounded-xl hover:bg-opacity-90 transition shadow-lg">
                                    Work with us
                                    <i data-feather="external-link" class="ml-2 w-4 h-4"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection