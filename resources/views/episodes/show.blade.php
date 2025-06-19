@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Video player -->
        <div class="col-md-8 mb-4">
            <div class="card bg-dark text-white border-0 shadow">
                <div class="ratio ratio-16x9">
                    <video controls>
                        <source src="{{ asset('storage/' . $episode->video_path) }}" type="video/mp4">
                        Trình duyệt của bạn không hỗ trợ video.
                    </video>
                </div>
                <div class="card-body">
                    <h1 class="card-title few-bold">{{ $movie->title }}</h1>
                    <p class="card-subtitle mb-3 text-secondary">Tập {{ $episode->episode_number }}</p>
                    
                    <!-- Navigation buttons -->
                    <div class="d-flex justify-content-between mb-4">
                        @php
                            $prevEpisode = $movie->episodes()
                                ->where('episode_number', '<', $episode->episode_number)
                                ->orderByDesc('episode_number')
                                ->first();

                            $nextEpisode = $movie->episodes()
                                ->where('episode_number', '>', $episode->episode_number)
                                ->orderBy('episode_number')
                                ->first();
                        @endphp

                        @if($prevEpisode)
                            <a href="{{ route('episode.show', ['movie' => $movie->slug, 'episode' => $prevEpisode->id]) }}" 
                               class="btn btn-outline-light">
                                <i class="bi bi-chevron-left"></i> Tập {{ $prevEpisode->episode_number }}
                            </a>
                        @else
                            <div></div>
                        @endif

                        @if($nextEpisode)
                            <a href="{{ route('episode.show', ['movie' => $movie->slug, 'episode' => $nextEpisode->id]) }}" 
                               class="btn btn-outline-light">
                                Tập {{ $nextEpisode->episode_number }} <i class="bi bi-chevron-right"></i>
                            </a>
                        @endif
                    </div>

                    <div class="episode-info">
                        <h2>Tập {{ $episode->episode_number }}: {{ $episode->title }}</h2>
                        @if($episode->description)
                            <p>{{ $episode->description }}</p>
                        @endif
                    </div>

                    <!-- Comments Section -->
                    <div class="mt-4">
                        <h4 class="mb-3">Bình luận</h4>
                        
                        @auth
                            <form action="{{ route('comments.store', $movie) }}" method="POST" class="mb-4">
                                @csrf
                                <div class="mb-3">
                                    <textarea name="content" class="form-control bg-dark text-white" rows="3" placeholder="Viết bình luận của bạn..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Gửi bình luận</button>
                            </form>
                        @else
                            <p class="text-muted">Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để bình luận.</p>
                        @endauth

                        <div class="comments-list">
                            @foreach($movie->comments()->with('user')->latest()->get() as $comment)
                                <div class="card bg-dark mb-3">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-2">
                                            <img src="{{ $comment->user->avatar ?? asset('images/default-avatar.png') }}" 
                                                 alt="Avatar" 
                                                 class="rounded-circle me-2" 
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                            <div>
                                                <h6 class="mb-0">{{ $comment->user->name }}</h6>
                                                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                        <p class="mb-0">{{ $comment->content }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Danh sách tập phim và phim đề cử -->
        <div class="col-md-4">
            <!-- Danh sách tập phim -->
            <div class="card bg-dark text-white shadow mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Danh sách tập phim</h5>
                </div>
                <ul class="list-group list-group-flush">
                    @foreach($movie->episodes()->orderBy('episode_number')->get() as $otherEpisode)
                    <a href="{{ route('episode.show', ['movie' => $movie->slug, 'episode' => $otherEpisode->id]) }}"
                       class="list-group-item list-group-item-action d-flex align-items-center {{ $otherEpisode->id === $episode->id ? 'active' : '' }}">
                        <img src="{{ asset('storage/' . $movie->poster_path) }}" 
                             alt="Thumbnail" 
                             class="me-3 rounded" style="width: 80px; height: 45px; object-fit: cover;">
                        <div>
                            <div class="fw-bold">Tập {{ $otherEpisode->episode_number }}</div>
                            <div class="text-muted small">{{ $otherEpisode->title }}</div>
                        </div>
                        <span class="ms-auto badge bg-secondary">{{ $otherEpisode->duration }}'</span>
                    </a>
                    @endforeach
                </ul>
            </div>

            <!-- Phim đề cử -->
            <div class="card bg-dark text-white shadow">
                <div class="card-header">
                    <h5 class="mb-0">Phim đề cử</h5>
                </div>
                <div class="card-body p-0">
                    @php
                        $recommendedMovies = \App\Models\Movie::whereHas('categories', function($query) use ($movie) {
                            $query->whereIn('categories.id', $movie->categories->pluck('id'));
                        })
                        ->where('id', '!=', $movie->id)
                        ->where('status', 'published')
                        ->latest()
                        ->take(5)
                        ->get();
                    @endphp

                    @foreach($recommendedMovies as $recommendedMovie)
                        <a href="{{ route('movies.show', $recommendedMovie) }}" class="text-decoration-none">
                            <div class="d-flex align-items-center p-3 border-bottom border-secondary">
                                <img src="{{ asset('storage/' . $recommendedMovie->poster_path) }}" 
                                     alt="{{ $recommendedMovie->title }}" 
                                     class="rounded me-3" 
                                     style="width: 100px; height: 150px; object-fit: cover;">
                                <div>
                                    <h6 class="text-white mb-1">{{ $recommendedMovie->title }}</h6>
                                    <div class="text-muted small">
                                        {{ $recommendedMovie->release_year }} • 
                                        {{ $recommendedMovie->duration }} phút
                                    </div>
                                    <div class="text-muted small">
                                        @foreach($recommendedMovie->categories as $category)
                                            <span class="badge bg-secondary">{{ $category->name }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
