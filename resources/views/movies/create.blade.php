@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg rounded-4 p-4" style="background-color: #1a1a2e;">
        <h3 class="mb-4 fw-bold text-center text-white">Thêm phim mới</h3>

        <form action="{{ route('movies.store') }}" method="POST" enctype="multipart/form-data" id="movie-form">
            @csrf

            {{-- Tên phim --}}
            <div class="mb-3">
                <label for="title" class="form-label text-white">Tên phim <span class="text-danger">*</span></label>
                <input type="text" class="form-control bg-dark text-white @error('title') is-invalid @enderror"
                    id="title" name="title" value="{{ old('title') }}" required>
                @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Mô tả --}}
            <div class="mb-3">
                <label for="description" class="form-label text-white">Mô tả <span class="text-danger">*</span></label>
                <textarea class="form-control bg-dark text-white @error('description') is-invalid @enderror"
                    id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Năm phát hành và Thời lượng --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="release_year" class="form-label text-white">Năm phát hành <span
                            class="text-danger">*</span></label>
                    <input type="number"
                        class="form-control bg-dark text-white @error('release_year') is-invalid @enderror"
                        id="release_year" name="release_year" value="{{ old('release_year') }}" min="1900"
                        max="{{ date('Y') + 1 }}" required>
                    @error('release_year')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="duration" class="form-label text-white">Thời lượng (phút) <span
                            class="text-danger">*</span></label>
                    <input type="number" class="form-control bg-dark text-white @error('duration') is-invalid @enderror"
                        id="duration" name="duration" value="{{ old('duration') }}" min="1" max="999" required>
                    @error('duration')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Loại phim --}}
            <div class="mb-3">
                <label class="form-label text-white">Loại phim <span class="text-danger">*</span></label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="type" id="single" value="single"
                            {{ old('type') == 'single' ? 'checked' : '' }} required>
                        <label class="form-check-label text-white" for="single">Phim lẻ</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="type" id="series" value="series"
                            {{ old('type') == 'series' ? 'checked' : '' }}>
                        <label class="form-check-label text-white" for="series">Phim bộ</label>
                    </div>
                </div>
                @error('type')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 d-none" id="episode-count-wrapper">
                <label for="episode_count" class="form-label text-white">Số tập <span
                        class="text-danger">*</span></label>
                <input type="number"
                    class="form-control bg-dark text-white @error('episode_count') is-invalid @enderror"
                    id="episode_count" name="episode_count" value="{{ old('episode_count') }}" min="1">
                @error('episode_count')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            {{-- Thể loại --}}
            <div class="mb-3">
                <label for="category_ids" class="form-label text-white">Thể loại <span
                        class="text-danger">*</span></label>
                <select class="form-select bg-dark text-white @error('category_ids') is-invalid @enderror"
                    id="category_ids" name="category_ids[]" multiple required>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ in_array($category->id, old('category_ids', [])) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                <small class="text-muted">Nhấn Ctrl/Cmd để chọn nhiều thể loại</small>
                @error('category_ids')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Poster --}}
            <div class="mb-3">
                <label for="poster" class="form-label text-white">Poster <span class="text-danger">*</span></label>
                <input type="file" class="form-control bg-dark text-white @error('poster') is-invalid @enderror"
                    id="poster" name="poster" accept="image/jpeg,image/png,image/webp" required>
                <small class="text-muted">Chỉ chấp nhận file JPEG, PNG hoặc WEBP, tối đa 5MB</small>
                @error('poster')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Video --}}
            <div class="mb-3">
                <label for="video" class="form-label text-white">Video <span class="text-danger">*</span></label>
                <input type="file" class="form-control bg-dark text-white @error('video') is-invalid @enderror"
                    id="video" name="video" accept="video/mp4,video/webm" required>
                <small class="text-muted">Chỉ chấp nhận file MP4 hoặc WEBM, tối đa 500MB</small>
                @error('video')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Quốc gia --}}
            <div class="mb-3">
                <label for="country_id" class="form-label text-white">Quốc gia <span
                        class="text-danger">*</span></label>
                <select class="form-select bg-dark text-white @error('country_id') is-invalid @enderror" id="country_id"
                    name="country_id" required>
                    <option value="">-- Chọn quốc gia --</option>
                    @foreach($countries as $country)
                    <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                        {{ $country->name }}
                    </option>
                    @endforeach
                </select>
                @error('country_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Nút --}}
            <div class="d-flex justify-content-between pt-3 border-top border-secondary mt-4">
                <a href="{{ route('movies.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Quay lại
                </a>
                <button type="submit" class="btn text-white" id="submit-btn"
                    style="background: linear-gradient(90deg, #f94ca4, #f14668); border: none;">
                    <span id="submit-text">Thêm phim</span>
                    <span id="submit-spinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
.form-control,
.form-select {
    border-color: #495057;
}

.form-control:focus,
.form-select:focus {
    background-color: #1e1e2e;
    color: white;
    border-color: #f94ca4;
    box-shadow: 0 0 0 0.25rem rgba(249, 76, 164, 0.25);
}

select[multiple] {
    height: auto;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('movie-form');
    const submitBtn = document.getElementById('submit-btn');
    const submitText = document.getElementById('submit-text');
    const submitSpinner = document.getElementById('submit-spinner');

    // Xử lý submit form
    form.addEventListener('submit', function(e) {
        // Hiển thị loading
        submitText.textContent = 'Đang xử lý...';
        submitSpinner.classList.remove('d-none');
        submitBtn.disabled = true;

        // Kiểm tra file
        const poster = document.getElementById('poster').files[0];
        const video = document.getElementById('video').files[0];

        if (poster && !['image/jpeg', 'image/png', 'image/webp'].includes(poster.type)) {
            alert('Poster phải là file ảnh (JPEG, PNG hoặc WEBP)');
            e.preventDefault();
            resetSubmitButton();
            return;
        }

        if (poster && poster.size > 5 * 1024 * 1024) {
            alert('Poster không được vượt quá 5MB');
            e.preventDefault();
            resetSubmitButton();
            return;
        }

        if (video && !['video/mp4', 'video/webm'].includes(video.type)) {
            alert('Video phải là file MP4 hoặc WEBM');
            e.preventDefault();
            resetSubmitButton();
            return;
        }

        if (video && video.size > 500 * 1024 * 1024) {
            alert('Video không được vượt quá 500MB');
            e.preventDefault();
            resetSubmitButton();
            return;
        }
    });

    function resetSubmitButton() {
        submitText.textContent = 'Thêm phim';
        submitSpinner.classList.add('d-none');
        submitBtn.disabled = false;
    }

    const singleRadio = document.getElementById('single');
    const seriesRadio = document.getElementById('series');
    const episodeWrapper = document.getElementById('episode-count-wrapper');

    function toggleEpisodeInput() {
        if (seriesRadio.checked) {
            episodeWrapper.classList.remove('d-none');
            document.getElementById('episode_count').required = true;
        } else {
            episodeWrapper.classList.add('d-none');
            document.getElementById('episode_count').required = false;
        }
    }

    singleRadio.addEventListener('change', toggleEpisodeInput);
    seriesRadio.addEventListener('change', toggleEpisodeInput);

    // Gọi lúc đầu nếu đã chọn sẵn old('type')
    toggleEpisodeInput();

});
</script>
@endpush