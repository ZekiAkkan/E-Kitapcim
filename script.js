document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.querySelector('.menu-toggle');
    const headerNav = document.querySelector('.header-nav');

    if (menuToggle && headerNav) {
        menuToggle.addEventListener('click', function () {
            headerNav.classList.toggle('show-menu');
            menuToggle.classList.toggle('open');
        });
    }
});


