@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Video player -->
        <div class="md:w-2/3">
            <div class="bg-gray-800 rounded-lg overflow-hidden">
                <div class="aspect-video bg-black">
                    <video controls class="w-full h-full">
                        <source src="{{ asset('storage/' . $episode->video_path) }}" type="video/mp4">
                        Trình duyệt của bạn không hỗ trợ video.
                    </video>
                </div>
                <div class="p-4">
                    <h1 class="text-2xl font-bold text-white mb-2">{{ $movie->title }}</h1>
                    <h2 class="text-xl text-gray-300 mb-4">Tập {{ $episode->episode_number }}: {{ $episode->title }}</h2>
                    
                    <!-- Nút chuyển tập -->
                    <div class="flex justify-between items-center mb-4">
                        @php
                            $prevEpisode = $movie->episodes->where('episode_number', '<', $episode->episode_number)->sortByDesc('episode_number')->first();
                            $nextEpisode = $movie->episodes->where('episode_number', '>', $episode->episode_number)->sortBy('episode_number')->first();
                        @endphp
                        
                        @if($prevEpisode)
                            <a href="{{ route('episode.show', ['movie' => $movie->slug, 'episode' => $prevEpisode->id]) }}" 
                               class="flex items-center gap-2 bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                                Tập {{ $prevEpisode->episode_number }}
                            </a>
                        @endif
                        
                        @if($nextEpisode)
                            <a href="{{ route('episode.show', ['movie' => $movie->slug, 'episode' => $nextEpisode->id]) }}" 
                               class="flex items-center gap-2 bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">
                                Tập {{ $nextEpisode->episode_number }}
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        @endif
                    </div>

                    <div class="prose prose-invert max-w-none">
                        <p>{{ $episode->description ?? 'Chưa có mô tả cho tập phim này.' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Danh sách tập phim khác -->
        <div class="md:w-1/3">
            <div class="bg-gray-800 rounded-lg p-4">
                <h2 class="text-xl font-bold text-white mb-4">Danh sách tập phim</h2>
                <div class="space-y-2">
                    @foreach($movie->episodes->sortBy('episode_number') as $otherEpisode)
                    <a href="{{ route('episode.show', ['movie' => $movie->slug, 'episode' => $otherEpisode->id]) }}" 
                       class="flex items-center gap-3 p-2 rounded-lg transition {{ $otherEpisode->id === $episode->id ? 'bg-gray-700 ring-2 ring-blue-500' : 'hover:bg-gray-700' }}">
                        <div class="w-20 aspect-video relative">
                            <img src="{{ $otherEpisode->thumbnail_path ?? $movie->poster_path }}" 
                                 alt="Tập {{ $otherEpisode->episode_number }}" 
                                 class="w-full h-full object-cover rounded">
                            <div class="absolute bottom-0 right-0 bg-black bg-opacity-75 px-1 text-xs">
                                {{ $otherEpisode->duration }}'
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-medium text-white">Tập {{ $otherEpisode->episode_number }}</h3>
                            <p class="text-xs text-gray-400 truncate">{{ $otherEpisode->title }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 