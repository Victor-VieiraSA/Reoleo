document.addEventListener('DOMContentLoaded', function () {
    const menuButton = document.querySelector('.mobile-menu-button');
    const navigation = document.querySelector('.main-navigation');

    if (menuButton && navigation) {
        menuButton.addEventListener('click', function () {
            const isOpen = navigation.classList.toggle('is-open');
            menuButton.setAttribute('aria-expanded', String(isOpen));
            menuButton.setAttribute('aria-label', isOpen ? 'Fechar menu' : 'Abrir menu');
            menuButton.innerHTML = isOpen
                ? '<i class="bi bi-x-lg"></i>'
                : '<i class="bi bi-list"></i>';
        });
    }
});
