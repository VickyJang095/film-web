<!-- Offcanvas Navbar Component -->
<nav class="navbar navbar-expand-lg navbar-dark background-transparent fixed-top">
    <div class="container">
        <!-- logo -->
        <a class="navbar-brand" href="{{ route('welcome') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" width="60pt">
        </a>

        <!-- toggle button -->
        <button class="navbar-toggler shadow-none border-0" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- sidebar -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
            aria-labelledby="offcanvasNavbarLabel">

            <!-- sidebar header -->
            <div class="offcanvas-header text-white border-bottom">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>

            <!-- sidebar body -->
            <div class="offcanvas-body d-flex flex-column flex-lg-row p-4 p-lg-0">
                <!-- nav items -->
                <ul class="navbar-nav justify-content-center align-items-center fs-5 flex-grow-1 pe-3">
                    <li class="nav-item mx-2">
                        <a class="nav-link {{ request()->routeIs('welcome') ? 'active' : '' }}" href="{{ route('welcome') }}">Trang chủ</a>
                    </li>
                    <li class="nav-item dropdown mx-2">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Quốc gia
                        </a>
                        <ul class="dropdown-menu">
                            @foreach($countries as $country)
                                <li><a class="dropdown-item" href="{{ route('country.show', $country->slug) }}">{{ $country->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item dropdown mx-2">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Thể loại
                        </a>
                        <ul class="dropdown-menu">
                            @foreach($categories as $category)
                                <li><a class="dropdown-item" href="{{ route('category.show', $category->slug) }}">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link {{ request()->routeIs('movies.latest') ? 'active' : '' }}" href="{{ route('movies.latest') }}">Phim mới</a>
                    </li>
                </ul>

                <!-- login/signup -->
                <div class="d-flex flex-column flex-lg-row justify-content-center align-items-center gap-3">
                    @guest
                        <a href="{{ route('register') }}" class="text-white text-decoration-none px-3 py-1 rounded-4"
                            style="background-color: #f94ca4;">Đăng ký</a>
                        <a href="{{ route('login') }}" class="text-white text-decoration-none px-3 py-1 rounded-4">Đăng nhập</a>
                    @else
                        <div class="nav-item dropdown me-4">
                            <button class="btn text-white dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Hồ sơ</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Đăng xuất</button>
                                    </form>
                                </li>
                                <li>
                                    <a href="{{ route('admin.dashboard') }}" class="dropdown-item" >Dashboard</a>
                                </li>
                            </ul>
                        </div>
                    @endguest
                </div>

                <!-- search form -->
                <form class="d-flex ms-3" action="{{ route('search') }}" method="GET" role="search">
                    <input class="form-control me-2" type="search" name="q" placeholder="Tìm kiếm phim..." aria-label="Search" value="{{ request('q') }}" />
                    <button class="btn text-white px-3 py-1 rounded-4" type="submit" style="background-color: #f94ca4;">Tìm</button>
                </form>
            </div>
        </div>
    </div>
</nav>
