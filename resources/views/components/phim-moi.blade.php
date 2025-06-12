<div class="container text-center pt-4">
    <div class="row align-items-center justify-content-start">
        <span class="col-sm-2 btn text-white rounded-3" id="PBM-btn"
            style="margin-right: 20px; background: linear-gradient(90deg, #f94ca4, #f14668); font-size: 20px;">PHIM
            MỚI
        </span>
    </div>
</div>
</div>
<div class="container text-center">
    <div class="row align-items-center pt-4 align-items-stretch ">
        @foreach ($latestMovies as $movie)
        <div class="col-12 col-sm-6 col-md-3 mb-4 d-flex" style="margin-left: -15px;">
            <div class="rounded-4 text-center movie-thumb text-white p-3 w-100 d-flex flex-column h-100">
                <img src="{{ $movie->poster_path }}" alt="{{ $movie->title }}"
                    class="img-fluid rounded-3 mb-3 flex-shrink-0">
                <h3 class="text-muted large mb-2">{{ $movie->title }}</h3>
                <p class="medium mb-1">{{ $movie->categories->pluck('name')->join(', ') }}</p>
                <p class="small mb-1">Năm phát hành: {{ $movie->release_year }}</p>
                <p class="small mb-2">Thời lượng: {{ $movie->duration }} phút</p>
                <p class="small mb-1">Số tập: {{ $movie->episodes }}</p>
                <p class="small">Rating: {{ $movie->rating }}/10</p>
                <a href="{{ route('movies.show', $movie) }}" target="_blank"
                    class="btn text-white px-3 py-2 rounded-4 shadow"
                    style="background: linear-gradient(90deg, #f94ca4, #f14668);">Xem Phim</a>
            </div>
        </div>
        @endforeach
    </div>
</div>