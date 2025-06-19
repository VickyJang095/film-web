@extends('layouts.app')

@section('content')
<div class="container py-5 mt-4">
    <div class="card shadow rounded-lg p-4 mx-auto" style="max-width: 800px; background-color: #1a1a2e;">
        <h3 class="mb-4 text-center text-white fw-bold">Chỉnh sửa phim</h3>

        <form action="{{ route('movies.update', $movie) }}" method="POST" enctype="multipart/form-data" id="update-movie-form">
            @csrf
            @method('PUT')

            {{-- Tên phim --}}
            <div class="mb-3">
                <label for="title" class="form-label text-white">Tên phim</label>
                <input type="text" name="title" id="title" value="{{ old('title', $movie->title) }}"
                    class="form-control bg-dark text-white @error('title') is-invalid @enderror" required>
                @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Mô tả --}}
            <div class="mb-3">
                <label for="description" class="form-label text-white">Mô tả</label>
                <textarea name="description" id="description" rows="4"
                    class="form-control bg-dark text-white @error('description') is-invalid @enderror"
                    required>{{ old('description', $movie->description) }}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Năm phát hành và Thời lượng --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="release_year" class="form-label text-white">Năm phát hành</label>
                    <input type="number" name="release_year" id="release_year" min="1900" max="{{ date('Y') + 5 }}"
                        value="{{ old('release_year', $movie->release_year) }}"
                        class="form-control bg-dark text-white @error('release_year') is-invalid @enderror" required>
                    @error('release_year')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="duration" class="form-label text-white">Thời lượng (phút)</label>
                    <input type="number" name="duration" id="duration" min="1" max="999"
                        value="{{ old('duration', $movie->duration) }}"
                        class="form-control bg-dark text-white @error('duration') is-invalid @enderror" required>
                    @error('duration')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Thể loại --}}
            <div class="mb-3">
                <label for="category_id" class="form-label text-white">Thể loại</label>
                <select name="categories[]" id="category_id" class="form-select bg-dark text-white" multiple required>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ in_array($category->id, old('categories', $movie->categories->pluck('id')->toArray())) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                @error('categories')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Loại phim --}}
            <div class="mb-3">
                <label class="form-label text-white">Loại phim <span class="text-danger">*</span></label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="type" id="single" value="single"
                            {{ old('type', $movie->type) === 'single' ? 'checked' : '' }} required>
                        <label class="form-check-label text-white" for="single">Phim lẻ</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="type" id="series" value="series"
                            {{ old('type', $movie->type) === 'series' ? 'checked' : '' }}>
                        <label class="form-check-label text-white" for="series">Phim bộ</label>
                    </div>
                </div>
                @error('type')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            {{-- Quốc gia --}}
            <div class="mb-3">
                <label for="country_id" class="form-label text-white">Quốc gia</label>
                <select name="country_id" id="country_id"
                    class="form-select bg-dark text-white @error('country_id') is-invalid @enderror" required>
                    <option value="">-- Chọn quốc gia --</option>
                    @foreach($countries as $country)
                    <option value="{{ $country->id }}"
                        {{ old('country_id', $movie->country_id) == $country->id ? 'selected' : '' }}>
                        {{ $country->name }}
                    </option>
                    @endforeach
                </select>
                @error('country_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Poster --}}
            <div class="mb-3">
                <label for="poster" class="form-label text-white">Poster</label>
                @if($movie->poster_path)
                @php
                $posterUrl = Str::startsWith($movie->poster_path, ['http://', 'https://'])
                ? $movie->poster_path
                : asset('storage/' . $movie->poster_path);
                @endphp
                <div class="mb-2">
                    <img src="{{ $posterUrl }}" alt="{{ $movie->title }}" class="img-thumbnail" style="width: 150px;">
                    <div class="form-check mt-2">
                        <input type="hidden" name="remove_poster" value="0">
                        <input class="form-check-input" type="checkbox" name="remove_poster" id="remove_poster" value="1" {{ old('remove_poster') ? 'checked' : '' }}>
                        <label class="form-check-label text-white" for="remove_poster">
                            Xóa poster hiện tại
                        </label>
                    </div>
                </div>
                @endif
                <input type="file" name="poster" id="poster"
                    class="form-control bg-dark text-white @error('poster') is-invalid @enderror"
                    accept="image/jpeg,image/png,image/webp">
                <small class="text-muted">Chỉ chấp nhận file ảnh (JPEG, PNG, WEBP), tối đa 5MB</small>
                @error('poster')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Nút hành động --}}
            <div class="d-flex justify-content-between pt-4 border-top border-secondary mt-3">
                <a href="{{ route('movies.index') }}" class="btn btn-secondary">Hủy</a>
                <button type="submit" class="btn btn-primary"
                    style="background: linear-gradient(90deg, #f94ca4, #f14668); border: none;">Cập nhật phim</button>
                <a href="{{ route('movies.show', $movie) }}" class="btn btn-info">Xem chi tiết</a>
            </div>
        </form>

        @if($movie->type === 'series')
            <div class="card my-4">
                <div class="card-header">Danh sách tập phim</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover">
                            <thead>
                                <tr>
                                    <th>Tập</th>
                                    <th>Tiêu đề</th>
                                    <th>Thời lượng</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($movie->episodes()->orderBy('episode_number')->get() as $episode)
                                <tr>
                                    <td>{{ $episode->episode_number }}</td>
                                    <td>{{ $episode->title }}</td>
                                    <td>{{ $episode->duration }} phút</td>
                                    <td>
                                        <span class="badge {{ $episode->status === 'published' ? 'bg-success' : 'bg-warning' }}">
                                            {{ $episode->status === 'published' ? 'Công khai' : 'Nháp' }}
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('episodes.destroy', ['movie' => $movie->id, 'episode' => $episode->id]) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa tập phim này?');"
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card my-4">
                <div class="card-header">Thêm tập phim mới</div>
                <div class="card-body">
                    <form action="{{ route('episodes.store', $movie) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-2">
                            <label for="episode_number" class="form-label">Số tập</label>
                            <input type="number" name="episode_number" id="episode_number" class="form-control" required min="1">
                        </div>
                        <div class="mb-2">
                            <label for="title" class="form-label">Tiêu đề tập (tuỳ chọn)</label>
                            <input type="text" name="title" id="title" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label for="description" class="form-label">Mô tả (tuỳ chọn)</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                        </div>
                        <div class="mb-2">
                            <label for="video" class="form-label">File video</label>
                            <input type="file" name="video" id="video" class="form-control" accept="video/mp4,video/webm" required>
                        </div>
                        <div class="mb-2">
                            <label for="thumbnail" class="form-label">Ảnh thumbnail (tuỳ chọn)</label>
                            <input type="file" name="thumbnail" id="thumbnail" class="form-control" accept="image/jpeg,image/png,image/webp">
                        </div>
                        <div class="mb-2">
                            <label for="duration" class="form-label">Thời lượng (phút, tuỳ chọn)</label>
                            <input type="number" name="duration" id="duration" class="form-control" min="0">
                        </div>
                        <div class="mb-2">
                            <label for="status" class="form-label">Trạng thái</label>
                            <select name="status" id="status" class="form-select">
                                <option value="published">Công khai</option>
                                <option value="draft">Nháp</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm tập</button>
                    </form>
                </div>
            </div>
        @endif
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

.list-group-item {
    border-color: #495057;
}
</style>
@endpush

@push('scripts')
@vite(['resources/js/edit-movie.js'])
@endpush