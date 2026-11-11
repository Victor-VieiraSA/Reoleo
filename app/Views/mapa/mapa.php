
<?php $coletor = ($modo ?? 'rede') === 'coletor'; ?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reoleo | <?= $coletor ? 'Mapa de Coletas Disponíveis' : 'Mapa de Pontos de Coleta' ?></title>
    <meta name="description" content="Explore e localize os pontos de coleta de óleo vegetal cadastrados na Baixada Santista.">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- CSS oficial do Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <link rel="stylesheet" href="<?= base_url('css/home.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/header.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/footer.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/mapa.css') ?>">
</head>
<body>

<div class="site-wrapper">

    <?= $this->include('layouts/headerLogado') ?>

    <main class="reoleo-home py-4 py-md-5">
        <div class="container reoleo-container">

            <?php if (! empty($sucesso)): ?>
                <div class="alert alert-success" role="status"><?= esc($sucesso) ?></div>
            <?php endif; ?>
            <?php if (! empty($erro)): ?>
                <div class="alert alert-danger" role="alert"><?= esc($erro) ?></div>
            <?php endif; ?>
            
            <!-- Cabeçalho da Página -->
            <div class="mapa-header-section mb-4">
                <?php if ($coletor): ?>
                    <span class="region-badge mb-2"><i class="bi bi-truck"></i> COLETAS EM ABERTO</span>
                    <h1 class="fw-bold text-dark m-0">Pontos com coleta disponível</h1>
                    <p class="text-muted mt-2 mb-0 mapa-descricao">
                        Veja no mapa os pontos de coleta da Baixada Santista que têm agendamento em aberto.
                        Escolha um marcador, confira data, turno e volume estimado e solicite a coleta.
                        O ponto de coleta confirma a sua solicitação.
                    </p>
                <?php else: ?>
                    <span class="region-badge mb-2"><i class="bi bi-geo-alt-fill"></i> GEOLOCALIZAÇÃO REGIONAL</span>
                    <h1 class="fw-bold text-dark m-0">Rede de Pontos de Coleta</h1>
                    <p class="text-muted mt-2 mb-0 mapa-descricao">
                        Navegue pelo mapa interativo e encontre os estabelecimentos parceiros na Baixada Santista. 
                        Escolha o ponto mais próximo de você para agendar o recolhimento sustentável do óleo usado.
                    </p>
                <?php endif; ?>
            </div>

            <!-- Card do Mapa Interativo -->
            <div class="mapa-card-wrap mb-4">
                <div id="mapa-reoleo-interativo" style="height: 480px; width: 100%;"></div>
            </div>

            <!-- Painel de Detalhes Dinâmico -->
            <div class="detalhes-ponto-card mb-5" id="painel-detalhes">
                <div class="d-flex align-items-center gap-3 text-muted py-2" id="detalhes-placeholder">
                    <i class="bi bi-info-circle fs-3 text-teal"></i>
                    <div>
                        <strong class="d-block text-dark">Nenhum ponto selecionado</strong>
                        <span class="small">
                            <?= $coletor
                                ? 'Clique em um marcador no mapa para ver as coletas abertas nesse ponto e solicitar a que preferir.'
                                : 'Clique em qualquer marcador no mapa acima para visualizar o responsável, endereço e dados de cadastro.' ?>
                        </span>
                    </div>
                </div>

                <div class="d-none" id="detalhes-conteudo">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 border-bottom pb-3 mb-3">
                        <div>
                            <span class="badge-region mb-1" id="info-cidade"></span>
                            <h3 class="fw-bold text-dark m-0" id="info-nome"></h3>
                            <span class="text-muted extra-small" id="info-tipo"></span>
                        </div>
                        <?php if (! $coletor): ?>
                            <a href="<?= base_url('Agendar') ?>" class="btn btn-reoleo-primary">
                                <i class="bi bi-calendar-check me-1"></i> Agendar Coleta Neste Ponto
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <span class="text-uppercase fw-bold text-muted extra-small d-block">Contato</span>
                            <strong class="text-dark fs-6" id="info-contato"></strong>
                        </div>
                        <div class="col-md-4">
                            <span class="text-uppercase fw-bold text-muted extra-small d-block">Endereço Operacional</span>
                            <span class="text-dark font-semibold" id="info-endereco"></span>
                        </div>
                        <div class="col-md-4">
                            <span class="text-uppercase fw-bold text-muted extra-small d-block">Documento / Registro</span>
                            <span class="badge-cnpj" id="info-documento"></span>
                        </div>
                    </div>
                    <?php if ($coletor): ?>
                        <div class="d-none mt-4" id="info-coletas"></div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Seção da Tabela com Bootstrap Padrão -->
            <div class="tabela-secao mt-5">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                    <div>
                        <span class="eyebrow"><?= $coletor ? 'COLETAS DISPONÍVEIS' : 'REGISTROS DA REDE' ?></span>
                        <h2 class="fw-bold text-dark m-0"><?= $coletor ? 'Agendamentos em aberto' : 'Pontos de Coleta Cadastrados' ?></h2>
                    </div>
                    <div class="busca-input-wrap">
                        <i class="bi bi-search"></i>
                        <input type="text" id="inputBusca" class="form-control" placeholder="Buscar por cidade, bairro ou nome...">
                    </div>
                </div>

                <div class="card-custom p-0 overflow-hidden shadow-sm border">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle m-0" id="tabelaPontos">
                            <thead class="table-light">
                                <?php if ($coletor): ?>
                                    <tr>
                                        <th class="ps-4">Ponto de coleta</th>
                                        <th>Data</th>
                                        <th>Turno</th>
                                        <th>Volume estimado</th>
                                        <th class="text-end pe-4">Ação</th>
                                    </tr>
                                <?php else: ?>
                                    <tr>
                                        <th class="ps-4">Estabelecimento / Ponto</th>
                                        <th>Município</th>
                                        <th>Bairro</th>
                                        <th>Endereço</th>
                                        <th>Status</th>
                                        <th class="text-end pe-4">Ação</th>
                                    </tr>
                                <?php endif; ?>
                            </thead>
                            <tbody>
                                <?= $coletor
                                    ? view('partials/mapaColetasLinhas', ['pontos' => $pontos])
                                    : view('partials/mapaPontosLinhas', ['pontos' => $pontos]) ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <?= $this->include('layouts/footer') ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- JS do Leaflet -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<?= view('partials/mapaPontosScript', ['pontos' => $pontos, 'publico' => $publico, 'modo' => $modo ?? 'rede']) ?>
</body>
</html>
