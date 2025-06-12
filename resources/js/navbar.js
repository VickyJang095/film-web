// Xử lý dropdown menu
document.addEventListener('DOMContentLoaded', function() {
    // Khởi tạo tất cả các dropdown
    var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
    var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
        return new bootstrap.Dropdown(dropdownToggleEl);
    });

    // Xử lý active state cho nav links
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        if (link.getAttribute('href') === window.location.pathname) {
            link.classList.add('active');
        }
    });
});
