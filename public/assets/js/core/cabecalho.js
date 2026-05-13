document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.getElementById('menuToggle');
    const mainHeaderMenu = document.getElementById('mainHeaderMenu');

    if (!menuToggle || !mainHeaderMenu) {
        return;
    }

    menuToggle.addEventListener('click', function () {
        mainHeaderMenu.classList.toggle('is-open');
    });

    const menuLinks = mainHeaderMenu.querySelectorAll('a');

    menuLinks.forEach(function (link) {
        link.addEventListener('click', function () {
            mainHeaderMenu.classList.remove('is-open');
        });
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth > 900) {
            mainHeaderMenu.classList.remove('is-open');
        }
    });
});