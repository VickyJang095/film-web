@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mt-5">
        <h2 class="mb-4 text-white fw-bold">🎬 Quản lý phim</h2>
        <div class="row g-4">

            <!-- Danh sách phim -->
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('movies.index') }}" class="text-decoration-none">
                    <div class="card border-0 rounded-4 shadow-lg bg-dark text-white hover-card h-100 p-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-film fa-2x me-3 text-primary"></i>
                            <h5 class="mb-0">Danh sách phim</h5>
                        </div>
                        <p class="text-secondary">Xem và quản lý tất cả phim có trong hệ thống.</p>
                    </div>
                </a>
            </div>

            <!-- Thêm phim mới -->
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('movies.create') }}" class="text-decoration-none">
                    <div class="card border-0 rounded-4 shadow-lg bg-dark text-white hover-card h-100 p-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-plus-circle fa-2x me-3 text-success"></i>
                            <h5 class="mb-0">Thêm phim mới</h5>
                        </div>
                        <p class="text-secondary">Thêm phim mới để người dùng có thể xem ngay.</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-card {
        transition: all 0.3s ease;
    }

    .hover-card:hover {
        background: linear-gradient(145deg, #1f1f1f, #2d2d2d);
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(255, 255, 255, 0.1);
    }
</style>
@endsection
