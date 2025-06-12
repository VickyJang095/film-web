@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10 mt-5">
    <div class="max-w-3xl mx-auto rounded-xl shadow-lg p-8 dark:bg-gray-900">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-6 flex items-start gap-3">
            <i class="fas fa-edit text-blue-500"></i> Chỉnh sửa phim
        </h1>

        <form action="{{ route('movies.update', $movie) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Tên phim --}}
            <div class="mb-4">
                <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1 me-4">Tên
                    phim</label>
                <input type="text" name="title" id="title" value="{{ old('title', $movie->title) }}" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 
                           @error('title') border-red-500 @enderror
                         dark:bg-gray-800 text-gray-900 dark:text-white">
                @error('title')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Mô tả --}}
            <div class="mb-4">
                <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1 me-4">Mô
                    tả</label>
                <textarea name="description" id="description" rows="4"
                    class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 
                           @error('description') border-red-500 @enderror
                           dark:bg-gray-800 text-gray-900 dark:text-white">{{ old('description', $movie->description) }}</textarea>
                @error('description')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Năm phát hành & Thời lượng --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                <div class="mb-4">
                    <label for="release_year"
                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1 me-4">Năm phát hành</label>
                    <input type="number" name="release_year" id="release_year"
                        value="{{ old('release_year', $movie->release_year) }}" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 
                               @error('release_year') border-red-500 @enderror
                               dark:bg-gray-800 text-gray-900 dark:text-white">
                    @error('release_year')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="duration" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1 me-4">Thời
                        lượng (phút)</label>
                    <input type="number" name="duration" id="duration" value="{{ old('duration', $movie->duration) }}"
                        class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 
                               @error('duration') border-red-500 @enderror
                               dark:bg-gray-800 text-gray-900 dark:text-white">
                    @error('duration')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Thể loại --}}
            <div class="space-y-2 mb-4">
                <label for="category_id" class="block text-sm font-semibold text-gray-700 me-4">Thể loại</label>
                <select name="category_id" id="category_id"
                    class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 @error('category_id') border-red-500 @enderror">
                    <option value="">-- Chọn thể loại --</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                @error('category_id')
                <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Poster --}}
            <div class="mb-4">
                <label for="poster"
                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1 me-4">Poster</label>
                @if($movie->poster_path)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $movie->poster_path) }}" alt="{{ $movie->title }}"
                        class="w-32 h-48 object-cover rounded-xl shadow-md">
                </div>
                @endif
                <input type="file" name="poster" id="poster" accept="image/*" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500
                           @error('poster') border-red-500 @enderror
                           dark:bg-gray-800 text-gray-900 dark:text-white">
                @error('poster')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Video --}}
            <div class="mb-4">
                <label for="video"
                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Video trailer</label>
                @if($movie->video_path)
                <div class="mb-3">
                    <video controls class="w-full rounded-xl">
                        <source src="{{ asset('storage/' . $movie->video_path) }}" type="video/mp4">
                        Trình duyệt không hỗ trợ video.
                    </video>
                </div>
                @endif
                <input type="file" name="video" id="video" accept="video/mp4" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500
                           @error('video') border-red-500 @enderror
                           dark:bg-gray-800 text-gray-900 dark:text-white">
                @error('video')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tập phim --}}
            <div class="mb-6">
                <label for="episodes" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Đăng tải tập phim</label>

                <div id="episode-list" class="space-y-4">
                    <div class="flex items-center gap-4">
                        <input type="text" name="episode_titles[]" placeholder="Tên tập phim"
                            class="w-1/2 px-4 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500
                                dark:bg-gray-800 text-gray-900 dark:text-white">
                        <input type="file" name="episode_files[]" accept="video/mp4"
                            class="w-1/2 px-4 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500
                                dark:bg-gray-800 text-gray-900 dark:text-white">
                    </div>
                </div>

                <button type="button" id="add-episode"
                    class="mt-3 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    + Thêm tập mới
                </button>
            </div>


            {{-- Nút --}}
            <div class="flex justify-end gap-4 pt-4 border-t mt-3 me-4 mb-4">
                <a href="{{ route('movies.show', $movie) }}"
                    class="inline-block px-4 py-2 text-gray-600 text-decoration-none hover:text-blue-600 hover:underline transition duration-150">
                    Hủy
                </a>
                <button type=" submit"
                    class="btn inline-block px-6 py-2 bg-blue-600 text-white font-medium rounded-lg shadow hover:bg-blue-700 transition duration-150"
                    style="background: linear-gradient(90deg, #f94ca4, #f14668);">
                    Update
                </button>
            </div>
        </form>
    </div>
    @push('scripts')
<script>
    document.getElementById('add-episode').addEventListener('click', function () {
        const list = document.getElementById('episode-list');

        const item = document.createElement('div');
        item.className = 'flex items-center gap-4';

        item.innerHTML = `
            <input type="text" name="episode_titles[]" placeholder="Tên tập phim"
                class="w-1/2 px-4 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500
                       dark:bg-gray-800 text-gray-900 dark:text-white">
            <input type="file" name="episode_files[]" accept="video/mp4"
                class="w-1/2 px-4 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500
                       dark:bg-gray-800 text-gray-900 dark:text-white">
        `;

        list.appendChild(item);
    });
</script>
@endpush
</div>
@endsection
