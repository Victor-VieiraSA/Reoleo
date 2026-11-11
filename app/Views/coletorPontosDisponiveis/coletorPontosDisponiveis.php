<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reoleo - Pontos Disponíveis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/coletorPontosDisponiveis.css') ?>">
</head>
<body class="d-flex flex-column flex-md-row min-vh-100">

    <nav class="navbar navbar-light bg-light d-md-none border-bottom px-3 py-2">
        <div class="container-fluid p-0">
            <div>
                <span class="fw-bold text-teal fs-5">Reoleo</span>
                <span class="text-muted extra-small d-block">Painel Integrado</span>
            </div>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMobile" aria-controls="sidebarMobile">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="sidebarMobile" aria-labelledby="sidebarMobileLabel">
        <div class="offcanvas-header border-bottom">
            <div>
                <h5 class="offcanvas-title fw-bold text-teal" id="sidebarMobileLabel">Reoleo</h5>
                <span class="text-muted extra-small">Painel Integrado</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column justify-content-between">
            <div>
                <div class="badge-region mb-4">
                    Região Baixada Santista
                </div>
                <nav class="nav flex-column">
                    <a href="<?= base_url('inicioColetor') ?>" class="nav-link-custom">
                        <i class="bi bi-grid-fill"></i> Painel Operacional
                    </a>
                    <a href="<?= base_url('coletorPontosDisponiveis') ?>" class="nav-link-custom active">
                        <i class="bi bi-calendar-event"></i> Ver Pontos Disponíveis
                    </a>
                    <a href="<?= base_url('homeLogado') ?>" class="nav-link-custom">
                        <i class="bi bi-house"></i> Portal Institucional
                    </a>
                </nav>
            </div>
            <div>
                <a href="<?= base_url('sair') ?>" class="btn-logout" <?= atributos_sair() ?>>
                    <i class="bi bi-box-arrow-left"></i> Encerrar Sessão
                </a>
            </div>
        </div>
    </div>

    <aside class="sidebar d-none d-md-flex flex-column justify-content-between">
        <div>
            <div class="mb-4 ps-2">
                <div class="sidebar-brand-title">Reoleo</div>
                <div class="sidebar-brand-sub">Painel Integrado</div>
            </div>

            <div class="badge-region mb-4">
                Região Baixada Santista
            </div>

            <nav class="nav flex-column">
                <a href="<?= base_url('inicioColetor') ?>" class="nav-link-custom">
                    <i class="bi bi-grid-fill"></i> Painel Operacional
                </a>
                <a href="<?= base_url('coletorPontosDisponiveis') ?>" class="nav-link-custom active">
                    <i class="bi bi-calendar-event"></i> Ver Pontos Disponíveis
                </a>
                <a href="<?= base_url('homeLogado') ?>" class="nav-link-custom">
                    <i class="bi bi-house"></i> Portal Institucional
                </a>
                <a href="<?= base_url('mapa') ?>" class="nav-link-custom">
                    <i class="bi bi-geo-alt"></i> Mapa dos Pontos
                </a>
            </nav>
        </div>

        <div class="ps-2">
            <a href="<?= base_url('sair') ?>" class="btn-logout" <?= atributos_sair() ?>>
                <i class="bi bi-box-arrow-left"></i> Encerrar Sessão
            </a>
        </div>
    </aside>

    <main class="flex-grow-1 p-3 p-md-4 overflow-hidden">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4">
            <h4 class="fw-bold m-0 text-dark">Painel de Monitoramento</h4>
            <div class="top-badge-profile align-self-start align-self-sm-auto">
                Perfil: <strong>Coletor</strong>
            </div>
        </div>

        <div class="mb-4">
            <h2 class="fw-bold text-dark mb-1 fs-3 fs-md-2">Pontos de Coleta Disponíveis na Baixada Santista</h2>
            <p class="text-muted small m-0">Solicitações abertas de descarte de óleo aguardando retirada por coletores,</p>
        </div>

        <div class="card-custom p-3 mb-4">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                <div class="input-group search-box flex-grow-1">
                    <span class="input-group-text border-0 bg-transparent ps-3">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="search" id="busca-pontos" class="form-control border-0 bg-transparent shadow-none" placeholder="Buscar por estabelecimento, bairro ou cidade">
                </div>
                <button class="btn btn-filtrar d-flex align-items-center justify-content-center gap-2 px-3 py-2">
                    <i class="bi bi-funnel"></i> Filtrar
                </button>
            </div>
        </div>

        <?php if (! empty($sucesso)): ?>
            <div class="alert alert-success d-flex align-items-center gap-2 mb-4" role="alert">
                <i class="bi bi-check-circle-fill"></i> <?= esc($sucesso) ?>
            </div>
        <?php endif; ?>

        <?php if (! empty($erro)): ?>
            <div class="alert alert-danger d-flex align-items-center gap-2 mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i> <?= esc($erro) ?>
            </div>
        <?php endif; ?>

        <div class="d-flex flex-column gap-3" id="lista-pontos">
            <?php if (empty($pontos)): ?>
                <div class="card-custom p-4 text-center text-muted">
                    Nenhum ponto disponível no momento. Novas solicitações aparecem aqui assim que um ponto de coleta agendar.
                </div>
            <?php endif; ?>

            <?php foreach ($pontos as $p): ?>
                <div class="card-custom p-3 p-md-4 ponto-item">
                    <div class="d-flex justify-content-between align-items-start gap-2 mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="ponto-icon-box flex-shrink-0">
                                <i class="bi bi-shop text-teal"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark m-0 fs-6 fs-md-5"><?= esc($p['ponto_nome']) ?></h5>
                                <div class="text-muted small mt-1">
                                    <i class="bi bi-geo-alt me-1"></i><?= esc($p['ponto_endereco'] . ', ' . $p['ponto_numero']) ?> • <?= esc($p['ponto_bairro'] . ', ' . $p['ponto_municipio']) ?>/SP
                                </div>
                            </div>
                        </div>
                        <div class="fs-5 fw-bold text-teal text-nowrap text-end">
                            <?= esc($p['volume_estimado']) ?>
                        </div>
                    </div>

                    <div class="info-banner-custom d-flex flex-column flex-sm-row justify-content-between align-items-sm-center p-3 gap-3">
                        <div class="d-flex align-items-center gap-2 small fw-semibold text-dark">
                            <i class="bi bi-calendar-event text-teal"></i>
                            <span><strong><?= esc(data_curta($p['data_coleta'])) ?></strong> • <?= esc(turno_detalhe($p['turno'])) ?></span>
                        </div>
                        <form action="<?= base_url('coletor/solicitar/' . (int) $p['id']) ?>" method="post" class="m-0">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-aceitar d-flex align-items-center justify-content-center gap-2 w-100">
                                <i class="bi bi-send-check"></i> Solicitar Coleta
                            </button>
                        </form>
                    </div>

                    <?php if (! empty($p['observacoes'])): ?>
                        <div class="text-muted small mt-3">
                            <i class="bi bi-chat-left-text me-1"></i> <?= esc($p['observacoes']) ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        
        const campoBusca = document.getElementById('busca-pontos');

        campoBusca.addEventListener('input', () => {
            const termo = campoBusca.value.trim().toLowerCase();

            document.querySelectorAll('.ponto-item').forEach((cartao) => {
                const aparece = termo === '' || cartao.textContent.toLowerCase().includes(termo);
                cartao.style.display = aparece ? '' : 'none';
            });
        });
    </script>
</body>
</html>