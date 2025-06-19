@extends('layouts.app')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 mb-4">
            <div class="card bg-dark text-white shadow">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <img src="{{ $user->avatar ? Storage::url($user->avatar) : asset('images/default-avatar.jpg') }}" 
                             alt="Avatar" 
                             class="rounded-circle img-thumbnail"
                             style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                    <h5 class="card-title mb-1">{{ auth()->user()->name }}</h5>
                    <p class="text-muted mb-3">{{ auth()->user()->email }}</p>
                    <div class="d-grid">
                        <button type="button" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#avatarModal">
                            <i class="bi bi-camera me-2"></i>Đổi ảnh đại diện
                        </button>
                    </div>

                    <!-- Thống kê -->
                    <div class="mt-4 pt-3 border-top border-secondary">
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <h5 class="mb-1">{{ $user->watchedMovies()->count() }}</h5>
                                <small class="text-muted">Phim đã xem</small>
                            </div>
                            <div class="col-6 mb-3">
                                <h5 class="mb-1">{{ $user->comments()->count() }}</h5>
                                <small class="text-muted">Bình luận</small>
                            </div>
                            <div class="col-6">
                                <h5 class="mb-1">{{ $user->ratings()->count() }}</h5>
                                <small class="text-muted">Đánh giá</small>
                            </div>
                            <div class="col-6">
                                <h5 class="mb-1">{{ $user->created_at->diffForHumans() }}</h5>
                                <small class="text-muted">Tham gia</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="card bg-dark text-white shadow">
                <div class="card-header">
                    <h4 class="mb-0">Thông tin cá nhân</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('profile.update') }}" class="needs-validation" novalidate>
                        @csrf
                        @method('patch')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Tên</label>
                                <input type="text" class="form-control bg-dark text-white @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control bg-dark text-white @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                            <input type="password" class="form-control bg-dark text-white @error('current_password') is-invalid @enderror" 
                                   id="current_password" name="current_password">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label">Mật khẩu mới</label>
                                <input type="password" class="form-control bg-dark text-white @error('password') is-invalid @enderror" 
                                       id="password" name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                                <input type="password" class="form-control bg-dark text-white" 
                                       id="password_confirmation" name="password_confirmation">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Lưu thay đổi
                            </button>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                                <i class="bi bi-trash me-2"></i>Xóa tài khoản
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Phim đã xem -->
            <div class="card bg-dark text-white shadow mt-4">
                <div class="card-header">
                    <h4 class="mb-0">Phim đã xem gần đây</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse($user->watchedMovies()->latest()->take(4)->get() as $movie)
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('movies.show', $movie) }}" class="text-decoration-none">
                                    <div class="card bg-dark border-0">
                                        <img src="{{ asset('storage/' . $movie->poster_path) }}" 
                                             class="card-img-top rounded" 
                                             alt="{{ $movie->title }}"
                                             style="height: 200px; object-fit: cover;">
                                        <div class="card-body p-2">
                                            <h6 class="card-title text-white mb-1">{{ $movie->title }}</h6>
                                            <small class="text-muted">{{ $movie->release_year }}</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-muted mb-0">Bạn chưa xem phim nào.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Danh sách phim yêu thích -->
            <div class="card bg-dark text-white shadow mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Phim yêu thích</h5>
                    <a href="#" class="btn btn-sm btn-outline-light">Xem tất cả</a>
                </div>
                <div class="card-body p-0">
                    @forelse($user->favoriteMovies()->latest()->take(3)->get() as $movie)
                        <a href="{{ route('movies.show', $movie) }}" class="text-decoration-none">
                            <div class="d-flex align-items-center p-3 border-bottom border-secondary">
                                <img src="{{ asset('storage/' . $movie->poster_path) }}" 
                                     alt="{{ $movie->title }}" 
                                     class="rounded me-3" 
                                     style="width: 60px; height: 90px; object-fit: cover;">
                                <div>
                                    <h6 class="text-white mb-1">{{ $movie->title }}</h6>
                                    <div class="text-muted small">
                                        <i class="bi bi-star-fill text-warning"></i> {{ number_format($movie->rating, 1) }}
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="p-3 text-center text-muted">
                            <p class="mb-0">Bạn chưa thêm phim yêu thích nào.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Bình luận gần đây -->
            <div class="card bg-dark text-white shadow mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Bình luận gần đây</h4>
                    <a href="#" class="btn btn-sm btn-outline-light">Xem tất cả</a>
                </div>
                <div class="card-body p-0">
                    @forelse($user->comments()->with('movie')->latest()->take(5)->get() as $comment)
                        <div class="p-3 border-bottom border-secondary">
                            <div class="d-flex align-items-center mb-2">
                                <img src="{{ asset('storage/' . $comment->movie->poster_path) }}" 
                                     alt="{{ $comment->movie->title }}" 
                                     class="rounded me-3" 
                                     style="width: 50px; height: 75px; object-fit: cover;">
                                <div>
                                    <h6 class="mb-1">
                                        <a href="{{ route('movies.show', $comment->movie) }}" class="text-white text-decoration-none">
                                            {{ $comment->movie->title }}
                                        </a>
                                    </h6>
                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            <p class="mb-0 text-muted">{{ Str::limit($comment->content, 100) }}</p>
                        </div>
                    @empty
                        <div class="p-3 text-center text-muted">
                            <p class="mb-0">Bạn chưa có bình luận nào.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Avatar Modal -->
<div class="modal fade" id="avatarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title">Đổi ảnh đại diện</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('profile.update-avatar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="avatar" class="form-label">Chọn ảnh</label>
                        <input type="file" class="form-control bg-dark text-white" id="avatar" name="avatar" accept="image/*" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title">Xóa tài khoản</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa tài khoản? Hành động này không thể hoàn tác.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <form action="{{ route('profile.destroy') }}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">Xóa tài khoản</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.form-control:focus {
    background-color: #1e1e2e;
    color: white;
    border-color: #f94ca4;
    box-shadow: 0 0 0 0.25rem rgba(249, 76, 164, 0.25);
}

.card {
    border: none;
    border-radius: 10px;
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-5px);
}

.card-header {
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.modal-content {
    border: none;
    border-radius: 10px;
}

.modal-header {
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.modal-footer {
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.btn {
    border-radius: 5px;
    transition: all 0.2s;
}

.btn:hover {
    transform: translateY(-2px);
}

.btn-primary {
    background: linear-gradient(45deg, #f94ca4, #ff6b6b);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(45deg, #ff6b6b, #f94ca4);
}

.btn-outline-light:hover {
    background: rgba(255, 255, 255, 0.1);
}

.rounded-circle {
    transition: transform 0.3s;
}

.rounded-circle:hover {
    transform: scale(1.05);
}

.border-secondary {
    border-color: rgba(255, 255, 255, 0.1) !important;
}

/* Animation cho thống kê */
@keyframes countUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.col-6 h5 {
    animation: countUp 0.5s ease-out forwards;
}

/* Hiệu ứng hover cho phim */
.card-img-top {
    transition: transform 0.3s;
}

.card:hover .card-img-top {
    transform: scale(1.05);
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #1e1e2e;
}

::-webkit-scrollbar-thumb {
    background: #f94ca4;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #ff6b6b;
}
</style>
@endpush
