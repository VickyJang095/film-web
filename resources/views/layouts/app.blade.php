<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Language" content="vi">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net"/>
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />


    <!-- Swiper.js -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>


    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/css/navbar.css', 'resources/js/navbar.js'])
    @vite(['resources/css/welcome.css', 'resources/js/welcome.js'])
    @vite(['resources/js/edit-movie.js'])

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <style>
    body {
        background-color: #121212;
        color: white;
        font-family: 'figtree', sans-serif;
    }

    .background-transparent {
        background-color: transparent !important;
    }

    main {
        padding-top: 80px;
    }
    </style>
</head>

<body class="vh-100" data-bs-theme="dark">

    <!-- Navbar -->
    <x-navbar class="navbar navbar-expand-lg navbar-dark background-transparent fixed-top"></x-navbar>

    <!-- Main content -->
    <main class="container">
        @yield('content')
    </main>

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



    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
    <!-- Swiper.js -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>
    @stack('scripts')
</body>

</html>