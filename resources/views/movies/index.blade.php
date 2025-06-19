@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col items-center justify-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800 text-center mb-4">Danh sách phim</h1>

        @if(auth()->user()->role === 'admin')
        <a href="{{ route('movies.create') }}"
            class="btn bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow transition"
            style="background: linear-gradient(90deg, #f94ca4, #f14668);">
            Thêm phim mới
        </a>
        @endif
    </div>

    @if(session('success'))
    <div
        class="max-w-xl mx-auto bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 text-center">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    @if($movies->isEmpty())
    <div class="text-center py-16">
        <p class="text-gray-500 text-lg">Chưa có phim nào trong hệ thống.</p>
    </div>
    @else
    <div class="container text-center">
        <div class="row align-items-center pt-4 align-items-stretch ">
            @foreach ($movies as $movie)
            <div class="col-12 col-sm-6 col-md-3 mb-4 d-flex" style="margin-left: -14px;">
                <div class="rounded-4 text-center movie-thumb text-white p-3 w-100 d-flex flex-column h-100">
                    <img src="{{ asset('storage/' . $movie->poster_path) }}" alt="{{ $movie->title }}"
                        class="img-fluid rounded-3 mb-3 flex-shrink-0">
                    <p class="text-muted large mb-2">{{ $movie->title }}</p>
                    <p class="medium mb-1">{{ $movie->categories->pluck('name')->join(', ') }}</p>
                    <p class="small mb-1">Năm: {{ $movie->release_year }}</p>
                    <p class="small mb-2">Thời lượng: {{ $movie->duration }} phút</p>
                    <p class="small">Rating: {{ $movie->rating }}/10</p>
                    <a href="{{ route('movies.edit', $movie) }}" target="_blank" class="btn text-white px-3 py-2 rounded-4 shadow" style="background: linear-gradient(90deg, #f94ca4, #f14668);">Chỉnh sửa</a>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-4">
            <a href="#" class="text-secondary small text-decoration-none">Xem thêm phim</a>
        </div>
    </div>
    @endif
</div>
@endsection