
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
            <?php if ((usuario_logado()['perfil'] ?? '') === 'coletor_licenciado'): ?>
                <a href="<?= base_url('coletorPontosDisponiveis') ?>">Coletas Disponíveis</a>
            <?php else: ?>
                <a href="<?= base_url('Agendar') ?>">Agendar Coleta</a>
            <?php endif; ?> 
            <a href="<?= base_url('mapa') ?>">Mapa da Região</a>
        </nav>

        <?php $usuarioHeader = usuario_logado(); ?>
        <div class="d-flex align-items-center gap-2">
            <a href="<?= base_url(rota_inicial($usuarioHeader['perfil'] ?? null)) ?>" class="header-user-badge">
                <i class="bi bi-person-circle"></i> Olá, <strong><?= esc($usuarioHeader['razao_social'] ?? 'Visitante') ?></strong>
            </a>

            <form action="<?= base_url('sair') ?>" method="post" class="m-0">
                <?= csrf_field() ?>
                <button type="submit" class="header-login-button" style="border: 0; cursor: pointer;">Sair</button>
            </form>
        </div>

    </div>
</header>
