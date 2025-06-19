<!-- PHIM LẺ Title -->
<div class="container text-center pt-5">
    <div class="row justify-content-start">
        <span class="col-auto phim-le-btn shadow d-flex align-items-center gap-2">
            <i class="fas fa-film"></i> <a href="#" class="text-decoration-none text-white">PHIM LẺ</a>
        </span>
    </div>
</div>

</div>
<div class="container pt-2">
    <div class="row g-4">
        @foreach ($movie as $movie)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex">
            <div class="card bg-dark text-white rounded-4 shadow-lg w-100 position-relative movie-card movie-thumb"
                style="overflow: hidden; transition: transform 0.3s ease;">
                
                <div class="overflow-hidden" style="border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                    <img src="{{ asset('storage/' . $movie->poster_path) }}" alt="{{ $movie->title }}"
                        class="img-fluid movie-poster" style="transition: transform 0.3s;">
                </div>

                <div class="card-body d-flex flex-column justify-content-between">
                    <h5 class="card-title mt-2">{{ $movie->title }}</h5>
                    <p class="text-muted small mb-1">{{ $movie->categories->pluck('name')->join(', ') }}</p>
                    <p class="small mb-3">⭐ Rating: {{ $movie->rating }}/10</p>
                    <a href="{{ route('movies.show', $movie) }}" target="_blank"
                       class="btn text-white px-3 py-2 rounded-4 shadow"
                       style="background: linear-gradient(90deg, #f94ca4, #f14668);">Xem Phim</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
/* Nút PHIM LẺ (giống PHIM MỚI nhưng có icon khác) */
.phim-le-btn {
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

/* Hover hiệu ứng */
.phim-le-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 0 30px rgba(249, 76, 164, 0.9);
}

/* Icon động */
.phim-le-btn i {
    animation: phimle-flicker 1s infinite alternate;
}

@keyframes phimle-flicker {
    0% { transform: scale(1); opacity: 0.85; }
    100% { transform: scale(1.1); opacity: 1; }
}

/* Hover card */
.movie-card:hover {
    transform: translateY(-8px);
}
.movie-card:hover .movie-poster {
    transform: scale(1.08);
}
</style>
