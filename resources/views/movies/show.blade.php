@extends('layouts.app')

@section('content')
<div class="container my-4 mt-6">
    <!-- THÔNG TIN PHIM -->
    <div class="row text-white rounded shadow p-4">
        <!-- Poster -->
        <div class="col-md-4 text-center mb-3">
            <img src="{{ $movie->poster_path }}" alt="{{ $movie->title }}" class="img-fluid rounded shadow"
                style="width: 80%; height: 450px; object-fit: cover;">
        </div>

        <!-- Nội dung -->
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <h2 class="fw-bold">{{ $movie->title }}</h2>
                @if(auth()->user()->role === 'admin')
                <div class="gap-2 align-items-center">
                    <a href="{{ route('movies.edit', $movie->id) }}"
                        class="btn btn-sm btn-warning d-flex align-items-center gap-1 py-1 px-2 mb-2">
                        <i class="fas fa-edit"></i> Sửa
                    </a>

                    <form action="{{ route('movies.destroy', $movie->id) }}" method="POST"
                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa phim này không?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger d-flex align-items-center gap-1 py-1 px-2">
                            <i class="fas fa-trash-alt"></i> Xóa
                        </button>
                    </form>
                </div>

                @endif
            </div>

            <div class="mb-3">
                <span class="badge bg-secondary">{{ $movie->release_year }}</span>
                <span class="badge bg-secondary">{{ $movie->duration }} phút</span>
                <span class="badge bg-secondary">{{ $movie->type === 'movie' ? 'Phim lẻ' : 'Phim bộ' }}</span>
                <span class="badge bg-secondary">{{ $movie->country->name }}</span>
            </div>

            <p class="text-light">{{ $movie->description }}</p>

            <div class="mb-3">
                <span class="text-warning fw-bold">★ {{ number_format($movie->rating, 1) }}</span>
                <span class="text-light ms-4">👁 {{ number_format($movie->views) }} lượt xem</span>
            </div>

            <div>
                <strong>Thể loại:</strong>
                @foreach($movie->categories as $category)
                <span class="badge" style="background-color: #f94ca4;">{{ $category->name }}</span>
                @endforeach
            </div>
        </div>
    </div>

    <!-- DANH SÁCH TẬP PHIM -->
    @if($movie->type === 'series')
    <div class="my-5">
        <h4 class="fw-bold text-white mb-3">Danh sách tập phim</h4>
        <div class="row g-3">
            @foreach($movie->episodes()->orderBy('episode_number')->get() as $episode)
            <div class="col-6 col-md-4 col-lg-2 mb-3">
                <a href="{{ route('episode.show', ['movie' => $movie->slug, 'episode' => $episode->id]) }}"
                    class="btn btn-outline-dark w-100 text-white">Tập {{ $episode->episode_number }}</a>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @if($relatedMovies->count())
    <!-- PHIM CÙNG THỂ LOẠI -->
    <div class="container pt-5">
        <!-- Tiêu đề -->
        <div class="row justify-content-start mb-4">
            <span class="col-auto phim-moi-btn shadow d-flex align-items-center gap-2">
                <i class="fas fa-clapperboard"></i>
                <a href="#" class="text-decoration-none text-white">PHIM CÙNG THỂ LOẠI</a>
            </span>
        </div>

        <!-- Danh sách phim -->
        <div class="row g-4">
            @foreach ($relatedMovies as $movie)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex">
                <div class="card bg-dark text-white rounded-4 shadow-lg w-100 position-relative movie-card movie-thumb"
                    style="overflow: hidden; transition: transform 0.3s ease;">
                    <div class="overflow-hidden" style="border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                        <img src="{{ $movie->poster_path }}" alt="{{ $movie->title }}" class="img-fluid movie-poster"
                            style="transition: transform 0.3s;">
                    </div>

                    <div class="card-body d-flex flex-column justify-content-between">
                        <h5 class="card-title mt-2 text-truncate">{{ $movie->title }}</h5>
                        <p class="text-muted small mb-1">{{ $movie->categories->pluck('name')->join(', ') }}</p>
                        <p class="small mb-3">⭐ Rating: {{ $movie->rating }}/10</p>
                        <a href="{{ route('movies.show', $movie->slug) }}"
                            class="btn text-white px-3 py-2 rounded-4 shadow"
                            style="background: linear-gradient(90deg, #f94ca4, #f14668);">Xem Phim</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif


    <!-- PHIM MOI -->
    <x-phim-moi></x-phim-moi>
    <!-- BÌNH LUẬN -->
    <div class="my-5">
        <h4 class="fw-bold text-white mb-3">Bình luận</h4>

        @auth
        <form action="{{ route('comments.store', $movie->id) }}" method="POST" class="mb-4">
            @csrf
            <div class="mb-2">
                <textarea name="content" rows="3" class="form-control" placeholder="Viết bình luận..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Gửi bình luận</button>
        </form>
        @endauth

        @foreach($movie->comments as $comment)
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="mb-1">{{ $comment->user->name }}</h6>
                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                    </div>
                    @if(auth()->id() === $comment->user_id)
                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-link text-danger">Xóa</button>
                    </form>
                    @endif
                </div>
                <p class="mt-2">{{ $comment->content }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
<style>
.movie-card:hover {
    transform: translateY(-8px);
}

.movie-card:hover .movie-poster {
    transform: scale(1.08);
}

.phim-moi-btn {
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

.phim-moi-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 0 30px rgba(249, 76, 164, 0.9);
}

.phim-moi-btn i {
    animation: clapper-flicker 1s infinite alternate;
}

@keyframes clapper-flicker {
    0% {
        transform: scale(1);
        opacity: 0.85;
    }

    100% {
        transform: scale(1.1);
        opacity: 1;
    }
}
</style>