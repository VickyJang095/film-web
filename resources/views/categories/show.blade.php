@extends('layouts.app')

@section('content')

<!-- TIÊU ĐỀ THỂ LOẠI -->
<div class="container text-center pt-5">
    <div class="row justify-content-start">
        <span class="col-auto phim-bo-btn shadow d-flex align-items-center gap-2">
            <i class="fas fa-layer-group"></i>
            <a href="#" class="text-decoration-none text-white">THỂ LOẠI {{ strtoupper($category->name) }}</a>
        </span>
    </div>
</div>

<!-- DANH SÁCH PHIM -->
<div class="container pt-4">
    @if($movies->isEmpty())
        <div class="text-center py-5">
            <p class="text-muted fs-5">Chưa có phim nào thuộc thể loại này.</p>
        </div>
    @else
    <div class="row g-4">
        @foreach ($movies as $movie)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex">
            <div class="card bg-dark text-white rounded-4 shadow-lg w-100 position-relative movie-card movie-thumb"
                style="overflow: hidden; transition: transform 0.3s ease;">
                
                <div class="overflow-hidden" style="border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                    <img src="{{ asset('storage/' . $movie->poster_path) }}" alt="{{ $movie->title }}"
                        class="img-fluid movie-poster" style="transition: transform 0.3s;">
                </div>

                <div class="card-body d-flex flex-column justify-content-center text-center">
                    <h5 class="card-title mt-2">{{ $movie->title }}</h5>
                    <p class="text-muted small mb-1">{{ $movie->categories->pluck('name')->join(', ') }}</p>
                    <p class="small">⭐ Rating: {{ $movie->rating }}/10</p>
                    <p class="small mb-3">Năm: {{ $movie->release_year }}</p>
                    <a href="{{ route('movies.show', $movie) }}" target="_blank"
                    class="btn text-white px-3 py-2 rounded-4 shadow"
                    style="background: linear-gradient(90deg, #f94ca4, #f14668);">Xem Phim</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

<!-- FontAwesome nếu chưa có -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- CSS tùy chỉnh -->
<style>
/* Hiệu ứng hover card */
.movie-card:hover {
    transform: translateY(-8px);
}
.movie-card:hover .movie-poster {
    transform: scale(1.08);
}

/* Nút tiêu đề */
.phim-bo-btn {
    font-size: 24px;
    padding: 12px 20px;
    font-weight: bold;
    color: white;
    border: none;
    border-radius: 50px;
    position: relative;
    overflow: hidden;
    z-index: 1;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

/* Hover */
.phim-bo-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 0 30px rgba(249, 76, 164, 0.9);
}

/* Icon động */
.phim-bo-btn i {
    animation: film-flicker 1s infinite alternate;
}

@keyframes film-flicker {
    0% { transform: scale(1); opacity: 0.85; }
    100% { transform: scale(1.1); opacity: 1; }
}
</style>

@endsection
