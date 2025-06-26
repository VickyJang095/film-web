document.addEventListener("DOMContentLoaded",function(){console.log("DOM loaded");const i=document.getElementById("update-movie-form");i&&(console.log("Form found"),i.addEventListener("submit",function(e){console.log("Form submitted"),console.log("Form data:",new FormData(i));const o=document.getElementById("poster");if(o&&o.files.length>0){const t=o.files[0],n=["image/jpeg","image/png","image/webp"],l=5*1024*1024;if(!n.includes(t.type))return alert("Poster phải là file ảnh (JPEG, PNG, WEBP)"),e.preventDefault(),!1;if(t.size>l)return alert("Poster không được vượt quá 5MB"),e.preventDefault(),!1}const c=document.getElementsByName("episode_files[]"),r=500*1024*1024;for(const t of c)if(t.files.length>0){const n=t.files[0];if(!["video/mp4","video/webm"].includes(n.type))return alert("Tập phim phải là file video (MP4, WEBM)"),e.preventDefault(),!1;if(n.size>r)return alert("Tập phim không được vượt quá 500MB"),e.preventDefault(),!1}return!0}));const s=document.getElementById("add-episode"),d=document.getElementById("episode-list");s&&d&&s.addEventListener("click",function(){const e=document.createElement("div");e.className="row mb-2",e.innerHTML=`
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
            `,d.appendChild(e),e.querySelector(".remove-episode").addEventListener("click",function(){e.remove()})})});
