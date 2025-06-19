@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-white mb-4">
        Kết quả tìm kiếm cho: <span class="text-warning">"{{ $query }}"</span>
    </h2>

    <div class="row g-4">
        @forelse ($movies as $movie)
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
        @empty
            <div class="col-12 text-white">
                <p>Không tìm thấy phim nào phù hợp với từ khóa.</p>
            </div>
        @endforelse
    </div>
</div>
<style>
/* Hiệu ứng hover card */
.movie-card:hover {
    transform: translateY(-8px);
}
.movie-card:hover .movie-poster {
    transform: scale(1.08);
}

.btn:hover {
    color: white;
}

@keyframes film-flicker {
    0% { transform: scale(1); opacity: 0.85; }
    100% { transform: scale(1.1); opacity: 1; }
}
</style>

@endsection
