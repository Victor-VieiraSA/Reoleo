document.addEventListener('DOMContentLoaded', () => {
    const abas = document.querySelectorAll('.tab');
    if (!abas.length) return;

    abas.forEach((aba) => {
        aba.addEventListener('click', () => {
            abas.forEach((a) => {
                const ativa = a === aba;
                a.classList.toggle('ativo', ativa);
                a.setAttribute('aria-selected', ativa);
                document.getElementById(a.getAttribute('aria-controls')).hidden = !ativa;
            });
        });
    });

    // Por enquanto não há backend: evita recarregar a página ao enviar
    document.querySelectorAll('.auth form').forEach((form) => {
        form.addEventListener('submit', (e) => e.preventDefault());
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const botao = document.querySelector('.menu-toggle');
    const menu = document.getElementById('menu-principal');
    if (!botao || !menu) return;

    botao.addEventListener('click', () => {
        const aberto = menu.classList.toggle('aberto');
        botao.setAttribute('aria-expanded', aberto);
        botao.setAttribute('aria-label', aberto ? 'Fechar menu' : 'Abrir menu');
    });
});