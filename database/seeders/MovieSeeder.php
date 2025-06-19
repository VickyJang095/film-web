<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;
use App\Models\Category;
use App\Models\Country;
use Illuminate\Support\Str;

class MovieSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo các bộ phim mẫu
        $movies = [
            [
                'title' => 'Cung Điện Ma Ám',
                'description' => 'Cung Điện Ma Ám – The Haunted Palace xoay quanh câu chuyện về Yun Gap, Yeo Ri và vua Yi Seong trong bối cảnh triều đại Joseon. Yun Gap, một quan chức cung đình với danh tiếng tốt và ngoại hình nổi bật, bất ngờ bị một sinh vật Imoogi chiếm hữu cơ thể, khiến anh trở thành tâm điểm của những lời đồn đại về sự mất trí. Imoogi này có mối liên hệ mật thiết với Yeo Ri, người từng là mối tình đầu của Yun Gap, kéo theo một chuỗi sự kiện đầy bí ẩn và cảm xúc trong cung điện.',
                'release_year' => 2025,
                'duration' => 60, // 60 phút mỗi tập
                'poster_path' => 'https://phongcach24h.com/wp-content/uploads/2025/04/cung-dien-ma-am-the-haunted-palace-4.jpg',
                'video_path' => 'https://youtu.be/TrRM2IxocgQ?si=AUcIw55fxB2ISMX6',
                'episodes' => 14,
                'type' => 'series',
                'country_id' => 1, // Hàn Quốc
                'status' => 'published',
                'views' => 1000,
                'rating' => 9.7
            ],
            [
                'title' => 'The Last Adventure',
                'description' => 'Phim kể về hai người bạn thân – Roland và Manu, cùng một nữ điêu khắc trẻ tên Laetitia, cùng nhau lên kế hoạch tìm kho báu từ một vụ đắm máy bay ở châu Phi. Trong hành trình này, họ phải đối mặt với hiểm nguy, kẻ thù, sự phản bội và những cảm xúc sâu sắc về tình bạn, tình yêu, ước mơ và cái chết.',
                'release_year' => 2024,
                'duration' => 150, // 2h 30m
                'poster_path' => 'https://m.media-amazon.com/images/M/MV5BZWFiOGJhNjEtOWFjNy00OTY4LWIyMzktOWNiNDA1ODUxOTljXkEyXkFqcGc@._V1_.jpg',
                'video_path' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'episodes' => 1,
                'type' => 'single',
                'country_id' => 2, // Mỹ
                'status' => 'published',
                'views' => 800,
                'rating' => 9.2
            ],
            [
                'title' => 'Love in Tokyo',
                'description' => 'Love in Tokyo là một bộ phim tình cảm hài lãng mạn kinh điển của điện ảnh Ấn Độ, lấy bối cảnh tại thủ đô Tokyo, Nhật Bản. Phim xoay quanh Ashok, một chàng trai Ấn Độ sang Nhật để tìm cháu trai của mình và vô tình gặp gỡ Asha, một cô gái trẻ đang cố gắng thoát khỏi cuộc hôn nhân sắp đặt. Trong hành trình đầy trắc trở, hiểu lầm và những màn hóa trang hài hước, hai người dần nảy sinh tình cảm với nhau.',
                'release_year' => 2024,
                'duration' => 125, // 2h 5m
                'poster_path' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQLIBQj4QfDMFTjPERaPxyXSTLoX9HjODlaDw&s',
                'video_path' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'episodes' => 24,
                'type' => 'series',
                'country_id' => 3, // Nhật Bản
                'status' => 'published',
                'views' => 600,
                'rating' => 9.0
            ],
            [
                'title' => 'The Dark Forest',
                'description' => 'Sau sự kiện liên lạc đầu tiên với nền văn minh ngoài hành tinh Trisolaris (ở phần 1 – The Three-Body Problem), nhân loại đối mặt với mối đe dọa xâm lược từ Trisolaris, dự kiến xảy ra trong 400 năm tới. Tuy nhiên, người Trisolaris đã cử những Sophon (siêu máy tính lượng tử có thể giám sát mọi hoạt động của con người) đến Trái Đất để ngăn chặn sự phát triển khoa học của nhân loại.',
                'release_year' => 2024,
                'duration' => 115, // 1h 55m
                'poster_path' => 'https://cdn11.bigcommerce.com/s-65f8qukrjx/images/stencil/800w/products/6415/17096/Liu_The_Dark_Forest_cover__60325.1687451114.jpg?c=1',
                'video_path' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'episodes' => 1,
                'type' => 'single',
                'country_id' => 2, // Mỹ
                'status' => 'published',
                'views' => 500,
                'rating' => 8.8
            ],
            [
                'title' => 'The Last Samurai',
                'description' => 'The Last Samurai lấy bối cảnh Nhật Bản vào cuối thế kỷ 19, khi đất nước đang trong quá trình hiện đại hóa và mở cửa với phương Tây. Phim kể về Nathan Algren (Tom Cruise thủ vai) – một cựu đại úy quân đội Hoa Kỳ, được thuê để huấn luyện quân đội đế quốc Nhật Bản theo phong cách phương Tây nhằm đàn áp cuộc nổi dậy của các samurai truyền thống.',
                'release_year' => 2024,
                'duration' => 165, // 2h 45m
                'poster_path' => 'https://m.media-amazon.com/images/M/MV5BMzkyNzQ1Mzc0NV5BMl5BanBnXkFtZTcwODg3MzUzMw@@._V1_FMjpg_UX1000_.jpg',
                'video_path' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'episodes' => 1,
                'type' => 'single',
                'country_id' => 3, // Nhật Bản
                'status' => 'published',
                'views' => 1200,
                'rating' => 9.3
            ],
        ];

        // Tạo phim và thêm thể loại
        foreach ($movies as $movieData) {
            $movieData['slug'] = Str::slug($movieData['title']);
            $movie = Movie::create($movieData);
            
            // Thêm thể loại cho từng phim
            switch ($movie->title) {
                case 'Cung Điện Ma Ám':
                    $movie->categories()->attach([1, 3]); // Phim truyền hình, Kinh dị
                    break;
                case 'The Last Adventure':
                    $movie->categories()->attach([2, 4]); // Hành động, Phiêu lưu
                    break;
                case 'Love in Tokyo':
                    $movie->categories()->attach([1, 5]); // Phim truyền hình, Tình cảm
                    break;
                case 'The Dark Forest':
                    $movie->categories()->attach([3, 6]); // Kinh dị, Bí ẩn
                    break;
                case 'The Last Samurai':
                    $movie->categories()->attach([2, 7]); // Hành động, Lịch sử
                    break;
            }
        }
    }
} 