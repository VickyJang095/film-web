<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Language" content="vi">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Film Web</title>

    @vite(['resources/css/navbar.css', 'resources/js/navbar.js'])
    @vite(['resources/css/welcome.css', 'resources/js/welcome.js'])
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
    .hero-section {
        background-image: url("https://minhtuanmobile.com/uploads/blog/cung-dien-ma-am-noi-dung-va-lich-chieu-chi-tiet-250421102856.png");
        background-size: cover;
        background-position: center;
        height: 100vh;
        color: white;
        position: relative;
        clip-path: ellipse(100% 90% at 50% 0%);
        border: none;
    }

    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background: rgba(0, 0, 0, 0.7);
    }

    .hero-content {
        position: relative;
        z-index: 1;
        padding-top: 200px;
        text-align: left;
        padding-left: 100px;
    }

    .watch-trailer {
        font-size: 30px;
        font-weight: bold;
        margin-top: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .watch-trailer:hover {
        transform: scale(1.05);
        color: #f94ca4;
    }

    .movie-title {
        font-size: 48px;
        font-weight: bold;
        color: white;
        text-align: left;
        margin-bottom: 20px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .movie-info {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 20px;
    }

    .movie-info-item {
        display: flex;
        align-items: center;
        gap: 5px;
        color: rgba(255, 255, 255, 0.8);
    }

    .movie-info-item i {
        color: #f94ca4;
    }

    .movie-description {
        max-width: 600px;
        color: rgba(255, 255, 255, 0.8);
        margin-bottom: 30px;
    }

    .action-buttons {
        display: flex;
        gap: 15px;
    }

    .btn-watch {
        background: linear-gradient(90deg, #f94ca4, #f14668);
        border: none;
        padding: 12px 30px;
        border-radius: 25px;
        color: white;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
    }

    .btn-watch:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(249, 76, 164, 0.3);
        color: white;
    }

    .btn-trailer {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 12px 30px;
        border-radius: 25px;
        color: white;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
    }

    .btn-trailer:hover {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }

    .watch-trailer-btn, .watch-full-btn {
        display: inline-block;
        border-radius: 25px;
        padding: 12px 30px;
        transition: all 0.3s ease-in-out;
        text-align: center;
        text-transform: uppercase;
        white-space: nowrap;
    }


    .watch-trailer-btn:hover {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(255, 255, 255, 0.1);
    }

    .watch-full-btn {
        background: linear-gradient(90deg, #f94ca4, #f14668);
        padding: 12px 30px;
        color: white;
        border: none;
        box-shadow: 0 4px 12px rgba(249, 76, 164, 0.3);
    }

    .watch-full-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 18px rgba(249, 76, 164, 0.5);
        color: white;
    }

    </style>
</head>

<body class="vh-100" data-bs-theme="dark">
    <div class="header-and-content-wrapper">
        <x-navbar class="navbar navbar-expand-lg navbar-dark background-transparent fixed-top"></x-navbar>
        <!-- watch trailer & display trailer & Introduction -->
        <section class="hero-section">
            <div class="hero-overlay"></div>
            <div class="hero-content container">
                @if($featuredMovie)
                <p class="movie-title">{{ $featuredMovie->title }}</p>
                <p class="movie-description">
                    {{ $featuredMovie->description }}
                </p>
                <div class="movie-info">
                    <div class="movie-info-item">
                        <i class="fas fa-star"></i>
                        <span>{{ number_format($featuredMovie->rating, 1) }}</span>
                    </div>
                    <div class="movie-info-item">
                        <i class="fas fa-clock"></i>
                        <span>{{ floor($featuredMovie->duration / 60) }}h {{ $featuredMovie->duration % 60 }}m</span>
                    </div>
                    <div class="movie-info-item">
                        <i class="fas fa-calendar"></i>
                        <span>{{ $featuredMovie->release_year }}</span>
                    </div>
                    <div class="movie-info-item">
                        <i class="fas fa-eye"></i>
                        <span>{{ $featuredMovie->views }} lượt xem</span>
                    </div>
                </div>
                <div class="action-buttons">
                    <a href="{{ route('movies.show', $featuredMovie) }}" class="btn btn-watch">
                        <i class="fas fa-play"></i>
                        Xem Phim
                    </a>
                    <div class="btn-trailer" id="playButton" data-trailer="{{ $featuredMovie->video_path }}">
                        <i class="fas fa-film"></i>
                        Xem Trailer
                    </div>
                </div>
                @endif
            </div>
        </section>
        <div class="video-container">
            <video id="trailerVideo" class="position-fixed w-50 h-50"
                style="object-fit: cover; top: 0; left: 0; display: none;" controls>
                <source src="{{ $featuredMovie->video_path }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <button id="backButton" class="btn btn-danger">
                <i class="fas fa-times"></i> Đóng
            </button>
        </div>
    </div>
    <!-- Slider Wrapper -->
    <div class="slider-wrapper" id="slide-wrapper">
        <!-- Slider Track -->
        <div class="slider-track" id="slides">
            @foreach($featuredMovies as $movie)
            <div class="container w-75 mx-auto slide">
                <!-- lớp nội dung -->
                <div class="filter-blur position-relative p-5">
                    <div class="row align-items-center justify-content-center">
                        <!-- infor left -->
                        <div class="col-md-7 text-dark">
                            <h1 class="fw-bold">{{ $movie->title }}</h1>
                            <p class="md-2">
                                @for($i = 1; $i <= 5; $i++) @if($i <=floor($movie->rating))
                                    <i class="fas fa-star text-warning"></i>
                                    @elseif($i - 0.5 <= $movie->rating)
                                        <i class="fas fa-star-half-alt text-warning"></i>
                                        @else
                                        <i class="far fa-star text-warning"></i>
                                        @endif
                                        @endfor
                                        <span class="ms-2">{{ number_format($movie->rating, 1) }}</span>
                                        <span class="mx-2">|</span>
                                        <span class="ms-2">{{ floor($movie->duration / 60) }}h
                                            {{ $movie->duration % 60 }}m</span>
                            </p>
                            <p class="text-muted">{{ Str::limit($movie->description, 150) }}</p>
                            <div class="d-flex gap-3 mt-3">
                                <a href="#" class="text-primary fw-semibold text-decoration-none px-3 py-2 watch-trailer-btn"
                                    data-trailer="{{ $movie->video_path }}">
                                    <i class="fas fa-film"></i> Xem Trailer
                                </a>
                                <a href="{{ route('movies.show', $movie) }}"
                                    class="btn text-white px-3 py-2 rounded-4 shadow watch-full-btn"
                                    style="background: linear-gradient(90deg, #f94ca4, #f14668);">
                                    <i class="fas fa-play"></i> Xem Phim
                                </a>
                            </div>
                        </div>

                        <!-- image right -->
                        <div class="col-md-5 text-center position-relative p-3">
                            <div class="rounded-4 overflow-hidden shadow justify-content-center align-items-center"
                                style="max-width: 200px; margin: auto;">
                                <img src="{{ asset('storage/' . $movie->poster_path) }}" alt="{{ $movie->title }}"
                                    class="img-fluid rounded-4">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="dots-container">
        <span class="dot" onclick="currentSlide(0)"></span>
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
    </div>
    <x-phim-moi></x-phim-moi>
    <x-movie-trending></x-movie-trending>
    <x-phim-bo></x-phim-bo>
    <x-phim-le></x-phim-le>

    <footer class="text-white py-4 mt-5" style="background-color:black;">
        <div class="container">
            <div class="row text-center text-md-start">
                <div class="col-md-4 mb-3">
                    <h5 class="text-muted">FILM WEB</h5>
                    <p>Xem phim chất lượng cao, tốc độ nhanh, không quảng cáo.</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5 class="text-muted">Liên kết</h5>
                    <ul class="list-unstyled">
                        <li><a href="/" class="text-white text-decoration-none">Trang chủ</a></li>
                        <li><a href="/phim-le" class="text-white text-decoration-none">Phim lẻ</a></li>
                        <li><a href="/phim-bo" class="text-white text-decoration-none">Phim bộ</a></li>
                        <li><a href="/lien-he" class="text-white text-decoration-none">Liên hệ</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3">
                    <h5 class="text-muted">Thông tin</h5>
                    <p>Email: support@phimweb.vn</p>
                    <p>Facebook: <a href="#" class="text-white">fb.com/phimweb</a></p>
                </div>
            </div>
            <div class="text-center border-top pt-3 mt-3">
                <p class="mb-0">&copy; {{ date('Y') }} PhimWeb. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>