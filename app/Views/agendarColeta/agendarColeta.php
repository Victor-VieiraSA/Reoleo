<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reoleo - Agendar Coleta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/agendarColeta.css') ?>">
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
                    <a href="<?= base_url('inicioPontoColeta') ?>" class="nav-link-custom">
                        <i class="bi bi-grid-fill"></i> Painel Operacional
                    </a>
                    <a href="#" class="nav-link-custom active">
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
                <a href="<?= base_url('/') ?>" class="btn-logout">
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
                <a href="<?= base_url('inicioPontoColeta') ?>" class="nav-link-custom">
                    <i class="bi bi-grid-fill"></i> Painel Operacional
                </a>
                <a href="#" class="nav-link-custom active">
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
            <a href="<?= base_url('/') ?>" class="btn-logout">
                <i class="bi bi-box-arrow-left"></i> Encerrar Sessão
            </a>
        </div>
    </aside>

    <main class="flex-grow-1 p-3 p-md-4 position-relative overflow-hidden">
        <div class="dashboard-backdrop position-absolute top-0 start-0 w-100 h-100 p-3 p-md-4">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4">
                <h4 class="fw-bold m-0 text-dark opacity-50">Painel de Monitoramento</h4>
                <div class="top-badge-profile opacity-50 align-self-start align-self-sm-auto">
                    Perfil: <strong>Ponto de Coleta</strong>
                </div>
            </div>

            <div class="card-custom p-3 p-md-4 mb-4 opacity-50">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div>
                        <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                            <span class="badge-cnpj">CNPJ 00.000.000/0001-00</span>
                            <span class="text-muted small">• Vila Mathias, Santos/SP</span>
                        </div>
                        <h2 class="fw-bold text-dark m-0 fs-3 fs-md-2">Bem-Vindo, Restaurante Estrela</h2>
                    </div>
                    <div>
                        <button class="btn btn-agendar-disabled d-flex align-items-center justify-content-center gap-2 w-100 w-md-auto" disabled>
                            <i class="bi bi-plus-lg"></i> Agendar nova coleta
                        </button>
                    </div>
                </div>
            </div>

            <div class="row g-3 g-md-4 mb-4 opacity-50">
                <div class="col-12 col-md-6">
                    <div class="card-custom p-3 p-md-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="text-uppercase fw-bold text-muted small">Total Reciclado</span>
                            <div class="icon-box-green">
                                <i class="bi bi-recycle"></i>
                            </div>
                        </div>
                        <div class="d-flex align-items-baseline">
                            <span class="display-4 fw-bold me-2 text-teal">89</span>
                            <span class="fs-5 fw-bold text-dark">Litros</span>
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
                            <span class="display-4 fw-bold me-2 text-dark">8</span>
                            <span class="fs-5 fw-bold text-dark">Coletas</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-overlay d-flex justify-content-center align-items-center p-3 p-sm-4">
            <div class="modal-card">
                <form action="" method="post">
                    <div class="mb-4">
                        <label class="form-label font-semibold text-dark mb-2">
                            <i class="bi bi-calendar-event me-1"></i> Data da Coleta <span class="text-teal">*</span>
                        </label>
                        <select class="form-select custom-select" name="data_coleta">
                            <option value="2026-10-10" selected>Sab. 10/10/2026</option>
                        </select>
                    </div>


                    <div class="mb-4">
                        <label class="form-label font-semibold text-dark mb-2">
                            <i class="bi bi-clock me-1"></i> Horário / Turno Preferencial <span class="text-teal">*</span>
                        </label>
                        <div class="row g-2 g-sm-3">
                            <div class="col-12 col-sm-6">
                                <label class="turno-card d-flex align-items-center justify-content-between p-3 w-100">
                                    <input type="radio" name="turno" value="manha" checked class="d-none">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="radio-dot"></div>
                                        <div>
                                            <div class="fw-bold small turno-titulo">Manhã</div>
                                            <div class="extra-small turno-subtitulo">08h00 às 12h00</div>
                                        </div>
                                    </div>
                                    <i class="bi bi-brightness-high fs-5 turno-icone"></i>
                                </label>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="turno-card d-flex align-items-center justify-content-between p-3 w-100">
                                    <input type="radio" name="turno" value="tarde" class="d-none">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="radio-dot"></div>
                                        <div>
                                            <div class="fw-bold small turno-titulo">Tarde</div>
                                            <div class="extra-small turno-subtitulo">13h00 às 18h00</div>
                                        </div>
                                    </div>
                                    <i class="bi bi-sunset fs-5 turno-icone"></i>
                                </label>
                            </div>
                        </div>
                    </div>


                    <div class="mb-1">
                        <label class="form-label font-semibold text-dark mb-2">
                            <i class="bi bi-droplet me-1"></i> Volume Estimado <span class="text-teal">*</span>
                        </label>
                        <select class="form-select custom-select" name="volume_estimado">
                            <option value="20-50" selected>20 a 50 Litros</option>
                        </select>
                    </div>
                    <div class="text-muted extra-small mb-4">Base para alocação do veículo</div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label font-semibold text-dark m-0">
                                <i class="bi bi-text-paragraph me-1"></i> Observações Operacionais
                            </label>
                            <span class="text-muted extra-small">Opcional</span>
                        </div>
                        <textarea class="form-control custom-textarea" name="observacoes" rows="3" placeholder="Ex: Entrada de serviço pelo portão lateral, falar com o encarregado Carlos..."></textarea>
                    </div>

                    <div class="d-flex flex-column align-items-center gap-3">
                        <button type="submit" class="btn btn-confirmar d-flex align-items-center justify-content-center gap-2 w-100">
                            <i class="bi bi-check-circle"></i> Confirmar Agendamento
                        </button>
                        <a href="<?= base_url('inicioPontoColeta') ?>" class="btn-cancelar">
                            Cancelar e voltar ao painel</a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>