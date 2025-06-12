@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 space-y-10">
    <!-- Thông tin phim chính -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 bg-gray-900 text-white rounded-lg shadow-lg overflow-hidden">
        <!-- Poster -->
        <div class="col-span-1">
            <img src="{{ $movie->poster_path }}" alt="{{ $movie->title }}" class="w-full h-full object-cover">
        </div>

        <!-- Nội dung -->
        <div class="col-span-2 p-6 space-y-6 text-gray-300">
            <!-- Tiêu đề + Hành động admin -->
            <div class="flex justify-between items-center">
                <h1 class="text-4xl font-extrabold text-white">{{ $movie->title }}</h1>
                @if(auth()->user()->role === 'admin')
                <div class="flex space-x-3">
                    <a href="{{ route('movies.edit', $movie->id) }}" class="text-sm font-medium text-yellow-400 hover:text-yellow-500 transition">Sửa</a>
                    <form action="{{ route('movies.destroy', $movie->id) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Xác nhận xóa?')" class="text-sm font-medium text-red-400 hover:text-red-600 transition">
                            Xóa
                        </button>
                    </form>
                </div>
                @endif
            </div>

            <!-- Thông tin nhanh -->
            <div class="flex flex-wrap gap-2 text-sm">
                <span class="bg-gray-800 px-3 py-1 rounded-full">{{ $movie->release_year }}</span>
                <span class="bg-gray-800 px-3 py-1 rounded-full">{{ $movie->duration }} phút</span>
                <span class="bg-gray-800 px-3 py-1 rounded-full">
                    {{ $movie->type === 'movie' ? 'Phim lẻ' : 'Phim bộ' }}
                </span>
                <span class="bg-gray-800 px-3 py-1 rounded-full">{{ $movie->country->name }}</span>
            </div>

            <!-- Mô tả -->
            <p class="leading-relaxed">{{ $movie->description }}</p>

            <!-- Rating & Lượt xem -->
            <div class="flex items-center space-x-8 text-sm">
                <div class="flex items-center text-yellow-400 font-medium">
                    <!-- SVG star -->
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span class="ml-1">{{ number_format($movie->rating, 1) }}</span>
                </div>
                <div class="flex items-center text-gray-400">
                    <svg class="w-5 h-5 mr-1 fill-current" viewBox="0 0 24 24">
                        <path d="M12 5c-7.633 0-12 6.275-12 7s4.367 7 12 7 12-6.275 12-7-4.367-7-12-7zm0 12c-3.309 0-6-2.243-6-5s2.691-5 6-5 6 2.243 6 5-2.691 5-6 5z"/>
                    </svg>
                    <span>{{ number_format($movie->views) }} lượt xem</span>
                </div>
            </div>

            <!-- Thể loại -->
            <div>
                <h2 class="font-semibold text-white">Thể loại:</h2>
                <div class="flex flex-wrap gap-2 mt-2">
                    @foreach($movie->categories as $category)
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 text-xs font-semibold rounded-full">
                            {{ $category->name }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>


    <!-- Danh sách tập phim -->
    @if($movie->type === 'series')
    <div class="space-y-4">
        <h2 class="text-2xl font-bold text-gray-800">Danh sách tập phim</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 d-flex">
            @foreach($movie->episodes()->orderBy('episode_number')->get() as $episode)
            <a href="{{ route('episode.show', ['movie' => $movie->slug, 'episode' => $episode->id]) }}"
               class="group rounded-4 px-1 py-2 shadow overflow-hidden hover:shadow-md transition">
                <div class="p-2">
                    <h3 class="text-sm font-semibold text-decoration-none">Tập {{ $episode->episode_number }}</h3>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Bình luận -->
    <div class="space-y-4">
        <h2 class="text-2xl font-bold text-gray-800">Bình luận</h2>

        @auth
        <form action="{{ route('comments.store', $movie->id) }}" method="POST" class="space-y-2">
            @csrf
            <textarea name="content" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Viết bình luận..."></textarea>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Gửi bình luận</button>
        </form>
        @endauth

        @foreach($movie->comments as $comment)
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <p class="font-semibold">{{ $comment->user->name }}</p>
                    <p class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                </div>
                @if(auth()->id() === $comment->user_id)
                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-500 text-sm hover:underline">Xóa</button>
                </form>
                @endif
            </div>
            <p class="text-gray-700">{{ $comment->content }}</p>
        </div>
        @endforeach
    </div>
</div>
@endsection
