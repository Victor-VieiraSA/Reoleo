<header class="site-header">
    <div class="header-inner">
        <a href="<?= base_url('/') ?>" class="brand" aria-label="Reoleo Baixada Santista, ir para o início">
            <span class="brand-name">Reoleo</span>
            <span class="brand-sub">Baixada Santista</span>
        </a>

        <nav id="menu-principal" class="main-nav" aria-label="Navegação principal">
            <a href="<?= base_url('/') ?>" <?= ($ativo ?? '') === 'inicio' ? 'aria-current="page"' : '' ?>>Início</a>
            <a href="<?= base_url('agendamentos/novo') ?>" <?= ($ativo ?? '') === 'agendar' ? 'aria-current="page"' : '' ?>>Agendar Coleta</a>
            <a href="<?= base_url('mapa') ?>" <?= ($ativo ?? '') === 'mapa' ? 'aria-current="page"' : '' ?>>Mapa da Região</a>
        </nav>

        <div class="header-actions">
            <a href="<?= base_url('entrar') ?>" class="btn-header">Entrar / Cadastro</a>
            <button type="button" class="menu-toggle" aria-expanded="false"
                    aria-controls="menu-principal" aria-label="Abrir menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</header>