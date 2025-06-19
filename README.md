# Film Web - Quản Lý Phim Laravel

## Giới thiệu

**Film Web** là một ứng dụng web quản lý phim được xây dựng bằng Laravel.  
Dự án hỗ trợ các chức năng quản lý phim, thể loại, người dùng, bình luận, đánh giá, và nhiều tính năng mở rộng khác.  
Giao diện thân thiện, dễ sử dụng, phù hợp cho cả người quản trị và người dùng cuối.

**Developer:** Hoàng Thị Minh Ngọc    **Mã SV:** 23010669

---

## Tính năng chính

- **Quản lý phim**: Thêm, sửa, xóa, cập nhật thông tin phim.
- **Quản lý thể loại phim**, phân loại theo nhiều tiêu chí.
- **Quản lý người dùng**, phân quyền (admin, user).
- **Đánh giá** và **bình luận phim**.
- **Tìm kiếm**, lọc phim theo tên, thể loại, năm phát hành, v.v.
- **Upload** poster, trailer, tập phim.
- Hệ thống xác thực, bảo mật **CSRF**.
- **Hỗ trợ seed dữ liệu mẫu** cho phát triển nhanh.
- **Tích hợp Vite**, hỗ trợ **Hot Reload** khi phát triển.
- **Responsive UI**, tối ưu cho cả desktop và mobile.

## Ghi chú:
- Test API bằng **Postman**
- Liên kết với database của **Aiven**

---

## Sơ đồ UML khối

![image](https://github.com/user-attachments/assets/e07b8b87-e4e5-4842-895a-1a45e0fc1d00)

**Giải thích:**

1. Routes định tuyến yêu cầu đến Controller.

2. Controllers xử lý logic HTTP, thường gọi tới Model hoặc Service.

3. Models/Eloquent tương tác trực tiếp với CSDL.

4. Views (Blade) là tầng trình bày.

5. Nếu dự án có thêm lớp Service/Repository, sẽ nằm giữa controller và model để tách biệt logic nghiệp vụ.

---

# Sơ đồ UML chức năng - Usecase

![ZLB12XCn5BpdAuQUBDZsBgLKyU1LLF0QT-CcR99Tis-58fvwyAeV87JnLbhmQejuIF4_za_Sq59qJPVU0ZFp9c_cBIlYZcgZcHPl2LJ0gKmIKkL4GggmhCgLBRdZ1YLFSfw95xJI0W7cDjE2CPvGuV0uDSfUtgyguHYxKZ1wrXu_WMHx_68plAlRmpSBxN-YbCgCy841G11XCi](https://github.com/user-attachments/assets/a2afb6cd-f1e4-4896-8e9f-f7422bc9c88a)


---

## Sơ đồ ERD
![Untitled](https://github.com/user-attachments/assets/d0541f63-56df-4fd6-b0af-d6c29b5c4f0c)

---
## Sơ đồ cấu trúc 

![image](https://github.com/user-attachments/assets/791c6f02-9795-466e-95ea-bb3fe9e6e333)


## Sơ đồ thuật toán
VD: Hiển thị phim theo thể loại

![image](https://github.com/user-attachments/assets/96eb62b9-36ef-4713-9517-dfeb901c7181)

## Lớp trọng điểm

| **Lớp**         | **Vai trò chính**                                                                 |
|------------------|------------------------------------------------------------------------------------|
| `Movie`          | Lõi của hệ thống – quản lý thông tin phim, liên kết với thể loại, quốc gia, tập, đánh giá, bình luận |
| `Category`       | Quản lý thể loại phim, liên kết nhiều-nhiều với `Movie` (nếu áp dụng pivot table) |
| `User`           | Quản lý tài khoản người dùng, phân quyền, xác thực đăng nhập                     |
| `Episode`        | Đại diện cho từng tập của phim (phim nhiều tập)                                  |
| `Rating`         | Lưu điểm đánh giá phim từ người dùng                                             |
| `Comment`        | Quản lý bình luận người dùng về từng phim                                        |
| `Country`        | Xác định quốc gia sản xuất của phim                                              |

---

## Các Controller chính

| **Controller**       | **Vị trí / Đường dẫn**                        | **Chức năng chính**                                                      |
|----------------------|-----------------------------------------------|---------------------------------------------------------------------------|
| `MovieController`    | `app/Http/Controllers/MovieController.php`    | Quản lý CRUD phim, upload poster/trailer, xử lý chi tiết phim           |
| `CategoryController` | `app/Http/Controllers/CategoryController.php` | Quản lý danh sách, thêm/xóa/sửa thể loại phim                            |
| `UserController`     | `app/Http/Controllers/UserController.php`     | Quản lý người dùng, phân quyền, truy xuất dữ liệu user                   |
| `EpisodeController`  | `app/Http/Controllers/EpisodeController.php`  | Quản lý các tập phim theo từng `Movie` (phim nhiều tập)                  |
| `RatingController`   | `app/Http/Controllers/RatingController.php`   | Xử lý chấm điểm đánh giá phim từ người dùng                              |
| `CommentController`  | `app/Http/Controllers/CommentController.php`  | Xử lý tạo/sửa/xóa bình luận cho từng phim                                |
| `CountryController`  | `app/Http/Controllers/CountryController.php`  | Quản lý quốc gia sản xuất phim                                            |

---
## Chức năng chính của dự án

- CRUD phim

<img width="400" alt="demo" src="https://github.com/user-attachments/assets/45da2a85-2559-4c0f-a302-4707b51a2f50" />

<img width="402" alt="demo1" src="https://github.com/user-attachments/assets/866031ed-623d-4335-989b-234f8091c0fa" />

<img width="403" alt="demo2" src="https://github.com/user-attachments/assets/a8f8ae5c-09e6-43e9-9903-e76df5d59d72" />

 UPDATE 

<img width="319" alt="demo3" src="https://github.com/user-attachments/assets/e383977d-ad9c-4663-8e4e-bdf26aedbf89" /> 

CREATE

<img width="912" alt="demo4" src="https://github.com/user-attachments/assets/c762edc7-43b9-420a-a5ab-c24177e8de97" /> 

DELETE & READ

 ## Code minh họa MovieController
 ```bash
<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Category;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Episode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\UpdateMovieRequest;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::with('categories')->latest()->paginate(12);
        return view('movies.index', compact('movies'));
    }

    public function show(Movie $movie)
    {
        // Tăng lượt xem mỗi lần vào trang chi tiết
        $movie->increment('views');

        $movie->load(['categories', 'comments.user', 'country', 'episodeList']);
        $relatedMovies = Movie::whereHas('categories', function($q) use ($movie) {
            return $q->whereIn('categories.id', $movie->categories->pluck('id'));
        })
        ->where('id', '!=', $movie->id)
        ->latest()
        ->take(12)
        ->get();        
        return view('movies.show', compact('movie', 'relatedMovies'));
    }

    public function create()
    {
        $categories = Category::all();
        $countries = Country::all();    
        return view('movies.create', compact('categories', 'countries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'release_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'duration' => 'required|integer|min:1',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'video' => 'nullable|file|mimes:mp4|max:102400',
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:categories,id',
            'country_id' => 'required|exists:countries,id',
            'type' => 'required|in:single,series',
            'episode_count' => 'required_if:type,series|nullable|integer|min:1',
        ]);

        if ($request->hasFile('poster')) {
            $validated['poster_path'] = $request->file('poster')->store('posters', 'public');
        }

        if ($request->hasFile('video')) {
            $validated['video_path'] = $request->file('video')->store('videos', 'public');
        }

        $movie = Movie::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'description' => $validated['description'],
            'release_year' => $validated['release_year'],
            'duration' => $validated['duration'],
            'poster_path' => $validated['poster_path'] ?? null,
            'video_path' => $validated['video_path'] ?? null,
            'country_id' => $validated['country_id'],
            'status' => 'published'
        ]);

        // Gán thể loại
        $movie->categories()->attach($validated['category_ids']);

        return redirect()->route('movies.show', $movie)
            ->with('success', 'Phim đã được thêm thành công.');
    }

    public function edit(Movie $movie)
    {
        $categories = Category::all();
        $countries = Country::all();
        return view('movies.edit', compact('movie', 'categories', 'countries'));
    }

    public function update(UpdateMovieRequest $request, Movie $movie)
    {
        Log::info('Update movie request data:', $request->all());
        
        $data = $request->validated();
        Log::info('Validated data:', $data);
        Log::info('Current movie type:', ['type' => $movie->type]);
        Log::info('New type value:', ['type' => $data['type']]);
        
        // Xử lý poster
        if ($request->hasFile('poster')) {
            if ($movie->poster_path) {
                Storage::disk('public')->delete($movie->poster_path);
            }
            $data['poster_path'] = $request->file('poster')->store('posters', 'public');
        } elseif ($request->input('remove_poster') === '1') {
            if ($movie->poster_path) {
                Storage::disk('public')->delete($movie->poster_path);
            }
            $data['poster_path'] = null;
        }

        // Cập nhật slug nếu title thay đổi
        if ($movie->title !== $data['title']) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Cập nhật thông tin phim
        $movie->update($data);
        Log::info('Movie updated:', $movie->toArray());

        // Cập nhật thể loại
        if (isset($data['categories'])) {
            $movie->categories()->sync($data['categories']);
            Log::info('Categories synced:', $data['categories']);
        }

        return redirect()->route('movies.show', $movie)
            ->with('success', 'Phim đã được cập nhật thành công.');
    }
    

    public function destroy(Movie $movie)
    {
        if ($movie->poster_path) {
            Storage::disk('public')->delete($movie->poster_path);
        }
        if ($movie->video_path) {
            Storage::disk('public')->delete($movie->video_path);
        }

        $movie->delete();

        return redirect()->route('movies.index')
            ->with('success', 'Phim đã được xóa thành công.');
    }
}
```

### Link
- Link repo: https://github.com/VickyJang095/film-web.git
- Link demo:
- Link web public:

### Công Nghệ
| **Công nghệ**                | **Vai trò**                                                                 |
|--------------------------|-------------------------------------------------------------------------|
| Laravel                  | Framework PHP, xây dựng backend, xử lý logic, routing, auth, migration  |
| PHP                      | Ngôn ngữ lập trình phía server, nền tảng backend                        |
| MySQL/MariaDB            | Hệ quản trị cơ sở dữ liệu, lưu trữ dữ liệu                              |
| Vite                     | Build, quản lý tài nguyên (JS/CSS), hot reload, tối ưu asset frontend   |
| Node.js & npm            | Cài đặt, quản lý package frontend, build asset với Vite                 |
| Blade Template Engine     | Engine template Laravel, xây dựng giao diện phía server                 |
| JavaScript (ES6+)        | Xử lý tương tác động, validate form, hiệu ứng, AJAX                    |
| HTML5 & CSS3             | Xây dựng cấu trúc và định dạng giao diện web                            |
| Bootstrap/Tailwind CSS   | Framework CSS, thiết kế giao diện responsive, hiện đại                  |
| WebSocket (Pusher, Echo) | Giao tiếp thời gian thực giữa client và server (realtime)               |
| Composer                 | Quản lý thư viện PHP, cài đặt package Laravel                           |
| Git                      | Quản lý mã nguồn, làm việc nhóm, theo dõi lịch sử thay đổi              |

---
## Cài đặt

### Yêu cầu hệ thống

- PHP >= 8.1
- Composer
- Node.js & npm
- MySQL / MariaDB / SQLite
- Laravel 10+

### Các bước cài đặt

```bash
# 1. Clone dự án
git clone https://github.com/your-username/film-web.git
cd film-web

# 2. Cài đặt các package PHP
composer install

# 3. Cài đặt các gói npm
npm install && npm run dev

# 4. Tạo file .env
cp .env.example .env

# 5. Tạo key ứng dụng
php artisan key:generate

# 6. Thiết lập cơ sở dữ liệu trong .env

# 7. Chạy migration và seed dữ liệu mẫu
php artisan migrate --seed

# 8. Khởi động server
php artisan serve
```

##  Một số lưu ý khi phát triển

- Khi thay đổi asset (JS/CSS), cần chạy lại `npm run build` hoặc `npm run dev`.
- Nếu gặp lỗi asset Vite (`manifest not found`), hãy xóa cache Laravel bằng:
  ```bash
  php artisan optimize:clear
  ```

## Ghi chú
**Tài khoản admin:**
- Admin: admin@example.com / password
- User: user@example.com / password
  
**Tích hợp:** Laravel Breeze + Sanctum (xác thực), Bootstrap (UI)

## Cấu trúc thư mục
```bash
film-web/
├── app/
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
│   └── .htaccess
├── resources/
│   ├── js/
│   └── views/
├── routes/
│   └── web.php
├── storage/
├── tests/
├── vite.config.js
└── ...
```
### Liên hệ
- Gmail: hoangminhngoc.tnhp@gmail.com
