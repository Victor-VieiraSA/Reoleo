<header class="login-header">
    <div class="login-header-inner">

        <a href="<?= base_url('/') ?>" class="login-brand" style="display: flex !important; flex-direction: row !important; align-items: center !important; gap: 4px !important; text-decoration: none;">
            <img src="<?= base_url('img/logov3.png') ?>" alt="Logo Reoleo" style="height: 48px; width: auto; margin-right: -4px;">
            <div style="display: flex; flex-direction: column; justify-content: center;">
                <span class="brand-name" style="line-height: 1; margin: 0;">Reoleo</span>
                <span class="brand-region" style="line-height: 1.2; margin: 0;">Baixada Santista</span>
            </div>
        </a>

        <nav class="login-navigation">
            <a href="<?= base_url('/') ?>">Início</a>
            <a href="<?= base_url('entrar') ?>">Agendar Coleta</a>
            <a href="<?= base_url('inicioPontoColeta') ?>">Inicio Ponto Coleta</a>
            <a href="<?= base_url('inicioColetor') ?>">Inicio Coletor</a>
            <a href="<?= base_url('mapaDeslogado') ?>">Mapa da Região</a>
        </nav>

        <a href="<?= base_url('entrar') ?>" class="header-login-button">
            Entrar | Cadastrar-se
        </a>

    </div>
</header>