<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reoleo - Painel do Ponto de Coleta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/inicioPontoColeta.css') ?>">
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
                <a href="inicioPontoColeta" class="nav-link-custom active">
                    <i class="bi bi-grid-fill"></i> Painel Operacional
                </a>
                <a href="<?= base_url('Agendar') ?>" class="nav-link-custom">
                    <i class="bi bi-calendar-event"></i> Agendar Coleta
                </a>
                <a href="<?= base_url('homeLogado') ?>" class="nav-link-custom">
                    <i class="bi bi-house"></i> Portal Institucional
                </a>
                <a href="<?= base_url('mapa') ?>" class="nav-link-custom">
                    <i class="bi bi-geo-alt"></i> Mapa dos Pontos
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
                <a href="#" class="nav-link-custom active">
                    <i class="bi bi-grid-fill"></i> Painel Operacional
                </a>
                <a href="<?= base_url('Agendar') ?>" class="nav-link-custom">
                    <i class="bi bi-calendar-event"></i> Agendar Coleta
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
                Perfil: <strong>Ponto de Coleta</strong>
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

        <div class="card-custom p-3 p-md-4 mb-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                        <span class="badge-cnpj"><?= esc(rotulo_documento(usuario_logado()['cpf_cnpj'] ?? '')) ?> <?= esc(formatar_documento(usuario_logado()['cpf_cnpj'] ?? '')) ?></span>
                        <span class="text-muted small">• <?= esc(local_usuario()) ?></span>
                    </div>
                    <h2 class="fw-bold text-dark m-0 fs-3 fs-md-2">Bem-Vindo, <?= esc(usuario_logado()['razao_social'] ?? '') ?></h2>
                </div>
                <div>
                    <a href="<?= base_url('Agendar') ?>" class="btn btn-agendar d-flex align-items-center justify-content-center gap-2 text-decoration-none w-100 w-md-auto">
                        <i class="bi bi-plus-lg"></i> Agendar nova coleta
                    </a>
                </div>
            </div>
        </div>

        <div class="row g-3 g-md-4 mb-4">
            <div class="col-12 col-md-6">
                <div class="card-custom p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="text-uppercase fw-bold text-muted small">Total Reciclado</span>
                        <div class="icon-box-green">
                            <i class="bi bi-recycle"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <span class="display-4 fw-bold me-2 text-teal"><?= number_format((int) $litros, 0, ',', '.') ?></span>
                        <span class="fs-5 fw-bold text-dark">Litros <small class="text-muted fw-normal extra-small">(estimado)</small></span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="card-custom p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="text-uppercase fw-bold text-muted small">Coletas Realizadas</span>
                        <div class="icon-box-blue">
                            <i class="bi bi-archive-fill"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <span class="display-4 fw-bold me-2 text-dark"><?= (int) $realizadas ?></span>
                        <span class="fs-5 fw-bold text-dark">Coletas</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-custom overflow-hidden">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center p-3 p-md-4 gap-2 border-bottom-0">
                <h5 class="fw-bold m-0 text-dark fs-6 fs-md-5">Histórico e Agendamentos de Coleta</h5>
                <button type="button" class="btn btn-filtrar d-flex align-items-center justify-content-center gap-2 px-3 py-2 align-self-start align-self-sm-auto" data-bs-toggle="collapse" data-bs-target="#filtroHistorico" aria-expanded="<?= array_filter($filtros) ? 'true' : 'false' ?>" aria-controls="filtroHistorico">
                    <i class="bi bi-funnel"></i> Filtrar<?= array_filter($filtros) ? ' (' . count(array_filter($filtros)) . ')' : '' ?>
                </button>
            </div>

            <?= view('partials/filtroHistorico', ['filtros' => $filtros, 'acao' => base_url('inicioPontoColeta')]) ?>

            <div class="table-responsive">
                <table class="table table-custom align-middle text-nowrap">
                    <thead>
                        <tr>
                            <th>Data & Turno</th>
                            <th>Volume Estimado</th>
                            <th>Coletor Responsável</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($agendamentos)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    <?php if (array_filter($filtros)): ?>Nenhum agendamento encontrado com esses filtros. <a href="<?= base_url('inicioPontoColeta') ?>">Limpar filtros</a><?php else: ?>Você ainda não tem coletas agendadas. Clique em <strong>Agendar nova coleta</strong> para começar.<?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach ($agendamentos as $ag): ?>
                            <tr>
                                <td>
                                    <div class="fw-bold text-dark"><?= esc(data_curta($ag['data_coleta'])) ?></div>
                                    <div class="text-muted small"><?= esc(turno_detalhe($ag['turno'])) ?></div>
                                </td>
                                <td class="fw-semibold text-dark"><?= esc($ag['volume_estimado']) ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <?php if (! empty($ag['coletor_nome'])): ?>
                                            <i class="bi bi-truck text-muted"></i>
                                            <span class="fw-semibold text-dark"><?= esc($ag['coletor_nome']) ?></span><?php if ($ag['status'] === 'Pendente'): ?><span class="badge bg-warning-subtle text-warning-emphasis fw-semibold">Solicitou a coleta</span><?php endif; ?>
                                        <?php else: ?>
                                            <i class="bi bi-hourglass-split text-muted"></i>
                                            <span class="text-muted">Aguardando coletor</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <span class="<?= esc(classe_status($ag['status'])) ?>">
                                        <i class="bi bi-circle-fill me-1"></i> <?= esc($ag['status']) ?>
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="dropdown">
                                        <a href="#" class="btn-options dropdown-toggle text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
                                            Opções
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 py-2 mt-1" style="border-radius: 10px; min-width: 190px;">
                                            <li class="dropdown-header d-flex justify-content-between align-items-center fw-bold text-dark pb-1 px-3">
                                                <span>Opções</span>
                                                <span class="text-muted small cursor-pointer" role="button" onclick="bootstrap.Dropdown.getInstance(this.closest('.dropdown').querySelector('.dropdown-toggle')).hide()">X</span>
                                            </li>
                                            <?php if ($ag['status'] === 'Pendente' && empty($ag['coletor_id'])): ?><li><a class="dropdown-item py-1 px-3 text-success fw-semibold small" href="<?= base_url('Agendar/editar/' . (int) $ag['id']) ?>">Editar</a></li><?php endif; ?>
                                            <?php if ($ag['status'] === 'Pendente' && ! empty($ag['coletor_id'])): ?><li><form action="<?= base_url('pontoColeta/aceitar/' . (int) $ag['id']) ?>" method="post" class="m-0"><?= csrf_field() ?><button type="submit" class="dropdown-item py-1 px-3 text-success fw-semibold small">Aceitar Coletor</button></form></li><li><form action="<?= base_url('pontoColeta/recusar/' . (int) $ag['id']) ?>" method="post" class="m-0" onsubmit="return confirm('Recusar este coletor? O agendamento volta para a lista de pontos disponíveis.');"><?= csrf_field() ?><button type="submit" class="dropdown-item py-1 px-3 text-danger fw-semibold small">Recusar Coletor</button></form></li><?php endif; ?>
                                            <?php if (($ag['status'] === 'Pendente' && empty($ag['coletor_id'])) || $ag['status'] === 'Confirmado'): ?><li><form action="<?= base_url('pontoColeta/excluir/' . (int) $ag['id']) ?>" method="post" class="m-0" onsubmit="return confirm('<?= $ag['status'] === 'Pendente' ? 'Excluir este agendamento?' : 'Cancelar este agendamento? O coletor já havia sido aceito.' ?>');"><?= csrf_field() ?><button type="submit" class="dropdown-item py-1 px-3 text-danger fw-semibold small"><?= $ag['status'] === 'Pendente' ? 'Deletar Agendamento' : 'Cancelar Agendamento' ?></button></form></li><?php elseif ($ag['status'] !== 'Pendente'): ?><li><span class="dropdown-item-text text-muted small px-3">Sem ações disponíveis</span></li><?php endif; ?>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>