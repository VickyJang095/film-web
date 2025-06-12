@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Thông tin phim -->
        <div class="md:w-2/3">
            <div class="bg-gray-800 rounded-lg overflow-hidden">
                <div class="aspect-video relative">
                    <img src="{{ $movie->poster_path }}" alt="{{ $movie->title }}" class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <h1 class="text-3xl font-bold mb-4">{{ $movie->title }}</h1>
                    <div class="flex flex-wrap gap-4 mb-4">
                        <span class="bg-gray-700 px-3 py-1 rounded-full text-sm">{{ $movie->release_year }}</span>
                        <span class="bg-gray-700 px-3 py-1 rounded-full text-sm">{{ $movie->duration }} phút</span>
                        <span class="bg-gray-700 px-3 py-1 rounded-full text-sm">{{ $movie->type === 'movie' ? 'Phim lẻ' : 'Phim bộ' }}</span>
                        <span class="bg-gray-700 px-3 py-1 rounded-full text-sm">{{ $movie->country->name }}</span>
                    </div>
                    <p class="text-gray-300 mb-6">{{ $movie->description }}</p>
                    <div class="flex items-center gap-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <span class="ml-1">{{ number_format($movie->rating, 1) }}</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-1">{{ number_format($movie->views) }} lượt xem</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Danh sách tập phim -->
        @if($movie->type === 'series')
        <div class="md:w-1/3">
            <h2 class="text-2xl font-bold mb-4">Danh sách tập phim</h2>
            <div class="bg-gray-800 rounded-lg p-4">
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($movie->episodes()->orderBy('episode_number')->get() as $episode)
                    <a href="{{ route('episode.show', ['movie' => $movie->slug, 'episode' => $episode->id]) }}" 
                       class="block bg-gray-700 rounded-lg hover:bg-gray-600 transition overflow-hidden">
                        <div class="aspect-video relative">
                            <img src="{{ $episode->thumbnail_path ?? $movie->poster_path }}" 
                                 alt="Tập {{ $episode->episode_number }}" 
                                 class="w-full h-full object-cover">
                            <div class="absolute bottom-0 right-0 bg-black bg-opacity-75 px-2 py-1 text-xs">
                                {{ $episode->duration }} phút
                            </div>
                        </div>
                        <div class="p-2">
                            <h3 class="text-sm font-medium">Tập {{ $episode->episode_number }}</h3>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden mt-8">
        <div class="md:flex">
            <div class="md:w-1/3">
                @if($movie->poster_path)
                    <img src="{{ asset('storage/' . $movie->poster_path) }}" alt="{{ $movie->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-400">Không có ảnh</span>
                    </div>
                @endif
            </div>
            
            <div class="p-6 md:w-2/3">
                <div class="flex justify-between items-start">
                    <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $movie->title }}</h1>
                    @if(auth()->user()->role === 'admin')
                        <div class="flex space-x-2">
                            <a href="{{ route('movies.edit', $movie->id) }}" class="text-yellow-500 hover:text-yellow-700">
                                Sửa
                            </a>
                            <form action="{{ route('movies.destroy', $movie->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Bạn có chắc chắn muốn xóa phim này?')">
                                    Xóa
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <div class="mb-4">
                    <p class="text-gray-600 mb-2">Năm phát hành: {{ $movie->release_year }}</p>
                    <p class="text-gray-600 mb-2">Thời lượng: {{ $movie->duration }} phút</p>
                    <p class="text-gray-600 mb-2">Lượt xem: {{ $movie->views }}</p>
                    <p class="text-gray-600 mb-2">Đánh giá: {{ number_format($movie->rating, 1) }}/5</p>
                </div>

                <div class="mb-6">
                    <h2 class="text-xl font-semibold mb-2">Thể loại</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach($movie->categories as $category)
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                {{ $category->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Phần bình luận -->
    <div class="mt-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Bình luận</h2>
        
        @auth
            <form action="{{ route('comments.store', $movie->id) }}" method="POST" class="mb-6">
                @csrf
                <div class="mb-4">
                    <textarea name="content" rows="3" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Viết bình luận của bạn..."></textarea>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    Gửi bình luận
                </button>
            </form>
        @endauth

        <div class="space-y-4">
            @foreach($movie->comments as $comment)
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <p class="font-semibold">{{ $comment->user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                        </div>
                        @if(auth()->id() === $comment->user_id)
                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-sm">
                                    Xóa
                                </button>
                            </form>
                        @endif
                    </div>
                    <p class="text-gray-700">{{ $comment->content }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection 