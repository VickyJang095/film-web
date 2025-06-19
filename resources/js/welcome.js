document.addEventListener('DOMContentLoaded', function () {
    // Video trailer
    const playButton = document.getElementById('playButton');
    const trailerVideo = document.getElementById('trailerVideo');
    const videoContainer = document.querySelector('.video-container');
    const backButton = document.getElementById('backButton');

    if (playButton && trailerVideo) {
        playButton.addEventListener('click', function () {
            const trailerUrl = this.getAttribute('data-trailer');
            if (trailerUrl) {
                trailerVideo.querySelector('source').src = trailerUrl;
                trailerVideo.load();
                videoContainer.style.display = 'block';
                trailerVideo.style.display = 'block';
                backButton.style.display = 'block';
                trailerVideo.play();
            }
        });
    }

    if (backButton) {
        backButton.addEventListener('click', function () {
            videoContainer.style.display = 'none';
            trailerVideo.style.display = 'none';
            backButton.style.display = 'none';
            trailerVideo.pause();
        });
    }

    // Slider logic
    const sliderWrapper = document.getElementById('slide-wrapper');
    const sliderTrack = document.getElementById('slides');
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');

    // Chỉ chạy slider logic nếu các element cần thiết tồn tại
    if (sliderWrapper && sliderTrack && slides.length > 0) {
        let currentIndex = 0;
        const slideCount = slides.length;

        function setupSlider() {
            // Thiết lập chiều rộng của track và từng slide theo %
            sliderTrack.style.width = `${slideCount * 100}%`;
            slides.forEach(slide => {
                slide.style.width = `${100 / slideCount}%`;
            });
            updateSlider();
        }

        function updateSlider() {
            const offset = -(100 / slideCount) * currentIndex;
            sliderTrack.style.transform = `translateX(${offset}%)`;
            if (dots.length > 0) {
                dots.forEach(dot => dot.classList.remove('active'));
                if (dots[currentIndex]) dots[currentIndex].classList.add('active');
            }
        }

        function showSlide(index) {
            currentIndex = index;
            updateSlider();
        }

        // Gán sự kiện click cho các dot
        if (dots.length > 0) {
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    clearInterval(slideInterval); // dừng auto slide khi người dùng nhấn
                    showSlide(index);
                    slideInterval = setInterval(nextSlide, 5000);
                });
            });
        }

        function nextSlide() {
            currentIndex = (currentIndex + 1) % slideCount;
            updateSlider();
        }

        // Auto chuyển slide
        let slideInterval = setInterval(nextSlide, 5000);

        // Setup khi resize
        window.addEventListener('resize', setupSlider);

        // Khởi tạo slider
        setupSlider();
    }

    // Watch trailer button phụ
    const watchTrailerButtons = document.querySelectorAll('.watch-trailer');
    if (watchTrailerButtons.length > 0 && trailerVideo) {
        watchTrailerButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const trailerUrl = this.getAttribute('data-trailer');
                if (trailerUrl) {
                    trailerVideo.querySelector('source').src = trailerUrl;
                    trailerVideo.load();
                    videoContainer.style.display = 'block';
                    trailerVideo.style.display = 'block';
                    backButton.style.display = 'block';
                    trailerVideo.play();
                }
            });
        });
    }
});
