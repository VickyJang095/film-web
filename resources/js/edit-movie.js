document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded');
    
    const form = document.getElementById('update-movie-form');
    if (form) {
        console.log('Form found');
        
        form.addEventListener('submit', function(event) {
            console.log('Form submitted');
            console.log('Form data:', new FormData(form));
            
            // Validate poster
            const posterInput = document.getElementById('poster');
            if (posterInput && posterInput.files.length > 0) {
                const file = posterInput.files[0];
                const validTypes = ['image/jpeg', 'image/png', 'image/webp'];
                const maxSize = 5 * 1024 * 1024; // 5MB
                
                if (!validTypes.includes(file.type)) {
                    alert('Poster phải là file ảnh (JPEG, PNG, WEBP)');
                    event.preventDefault();
                    return false;
                }
                
                if (file.size > maxSize) {
                    alert('Poster không được vượt quá 5MB');
                    event.preventDefault();
                    return false;
                }
            }
            
            // Validate episodes
            const episodeFiles = document.getElementsByName('episode_files[]');
            const maxEpisodeSize = 500 * 1024 * 1024; // 500MB
            
            for (const fileInput of episodeFiles) {
                if (fileInput.files.length > 0) {
                    const file = fileInput.files[0];
                    const validTypes = ['video/mp4', 'video/webm'];
                    
                    if (!validTypes.includes(file.type)) {
                        alert('Tập phim phải là file video (MP4, WEBM)');
                        event.preventDefault();
                        return false;
                    }
                    
                    if (file.size > maxEpisodeSize) {
                        alert('Tập phim không được vượt quá 500MB');
                        event.preventDefault();
                        return false;
                    }
                }
            }
            
            return true;
        });
    }
    
    // Add episode functionality
    const addEpisodeBtn = document.getElementById('add-episode');
    const episodeList = document.getElementById('episode-list');
    
    if (addEpisodeBtn && episodeList) {
        addEpisodeBtn.addEventListener('click', function() {
            const episodeDiv = document.createElement('div');
            episodeDiv.className = 'row mb-2';
            episodeDiv.innerHTML = `
                <div class="col-md-3">
                    <input type="number" name="episode_numbers[]" class="form-control bg-dark text-white" placeholder="Số tập" min="1">
                </div>
                <div class="col-md-5">
                    <input type="text" name="episode_titles[]" class="form-control bg-dark text-white" placeholder="Tên tập (tùy chọn)">
                </div>
                <div class="col-md-3">
                    <input type="file" name="episode_files[]" class="form-control bg-dark text-white" accept="video/mp4,video/webm">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn-sm remove-episode">×</button>
                </div>
            `;
            
            episodeList.appendChild(episodeDiv);
            
            // Add remove functionality
            const removeBtn = episodeDiv.querySelector('.remove-episode');
            removeBtn.addEventListener('click', function() {
                episodeDiv.remove();
            });
        });
    }
}); 