document.addEventListener('DOMContentLoaded', function () {
    var lastScrollTop = 0;
    var navbar = document.querySelector('.navbar');
    var navbarHeight = navbar.offsetHeight;

    window.addEventListener('scroll', function () {
        var currentScrollTop = document.documentElement.scrollTop;

        if (currentScrollTop > lastScrollTop && currentScrollTop > navbarHeight) {
            // Scroll down past the header height
            navbar.style.top = '-' + navbarHeight + 'px';
        } else if (currentScrollTop < lastScrollTop) {
            // Scroll up
            navbar.style.top = '0';
        }

        lastScrollTop = currentScrollTop <= 0 ? 0 : currentScrollTop; // For Mobile or negative scrolling
    }, false);
});

window.onscroll = () => {

    var navbut = document.getElementById('navibut');
    var navigation = document.getElementById('navigation');
    
    navbut.classList.add('collapsed');
    navigation.classList.remove('show');
};