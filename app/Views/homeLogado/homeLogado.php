<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reoleo | Baixada Santista</title>
    <meta name="description" content="Conexão inteligente para destinação sustentável de óleo usado na Baixada Santista.">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="<?= base_url('css/homeLogado.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/header.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/footer.css') ?>">

</head>
<body>

    <?= $this->include('layouts/headerLogado') ?>

    <main class="reoleo-home">
        <section class="hero-section">
            <div class="container reoleo-container">
                <div class="row align-items-center hero-row">
                    <div class="col-lg-7 hero-copy">
                        <span class="region-badge"><i class="bi bi-geo-alt-fill"></i> BAIXADA SANTISTA</span>
                        <h1>Conexão inteligente para destinação sustentável de óleo usado</h1>
                        <p class="hero-description">
                            Plataforma metropolitana que une geradores comerciais, bares e
                            condomínios a empresas de coleta na Baixada Santista, transformando
                            resíduos em biocombustíveis e preservando o ecossistema estuarino.
                        </p>
                        <div class="d-flex flex-wrap align-items-center gap-3">
                            <a href="<?= base_url('inicioPontoColeta') ?>" class="btn btn-reoleo-primary">
                                Acessar Meu Painel <i class="bi bi-arrow-right"></i>
                            </a>
                            <div class="top-badge-profile">
                                Perfil: <strong>Ponto de Coleta</strong>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5 hero-visual">
                        <div class="hero-image-wrap">
                            <img src="<?= base_url('img/img pag 1.png') ?>"
                                alt="Vista aérea do estuário da Baixada Santista" class="hero-image">
                            <div class="environment-card">
                                <div class="environment-icon"><i class="bi bi-droplet"></i></div>
                                <div>
                                    <strong>Estuário Preservado</strong>
                                    <span>Cada litro recolhido evita a poluição de água marinha.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="workflow-section">
        <div class="container reoleo-container">
            <div class="section-heading">
                <span class="eyebrow">FLUXO OPERACIONAL TRANSPARENTE</span>
                <h2>Como funciona a rede integrada Reoleo</h2>
            </div>
            <div class="row g-3 workflow-grid">
                <div class="col-md-4">
                    <a href="<?= base_url('entrar') ?>" class="workflow-card text-decoration-none d-block">
                        <div class="workflow-card-top">
                            <span class="step-number step-teal">01</span>
                            <i class="bi bi-ui-checks-grid step-icon icon-teal"></i>
                        </div>
                        <span class="card-eyebrow text-teal">PRIMEIRO PASSO</span>
                        <h3>Cadastre-se</h3>
                        <p class="card-note text-teal">Adesão gratuita <i class="bi bi-check-circle"></i></p>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="<?= base_url('Agendar') ?>" class="workflow-card text-decoration-none d-block">
                        <div class="workflow-card-top">
                            <span class="step-number step-blue">02</span>
                            <i class="bi bi-calendar2-week step-icon icon-blue"></i>
                        </div>
                        <span class="card-eyebrow text-blue">LOGÍSTICA FLEXÍVEL</span>
                        <h3>Agende a Coleta</h3>
                        <p class="card-note text-blue">Coleta pontual sob demanda <i class="bi bi-clock"></i></p>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="<?= base_url('mapa') ?>" class="workflow-card text-decoration-none d-block">
                        <div class="workflow-card-top">
                            <span class="step-number step-green">03</span>
                            <i class="bi bi-journal-text step-icon icon-green"></i>
                        </div>
                        <span class="card-eyebrow text-green">GARANTIA E ESG</span>
                        <h3>Acompanhe a Destinação</h3>
                        <p class="card-note text-green">Certificado digital imediato <i class="bi bi-patch-check"></i></p>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="ecosystem-section">
        <div class="container reoleo-container">
            <div class="row align-items-center ecosystem-row">
                <div class="col-lg-6 ecosystem-copy">
                    <span class="eyebrow">ECOSSISTEMA LITORAL INTEGRADO</span>
                    <h2>Preservando as bacias e praias da Baixada Santista</h2>
                    <p class="p-informativo">
                        O descarte irregular de óleos vegetais compromete gravemente as
                        galerias pluviais urbanas e satura os manguezais do canal estuarino
                        de Santos e São Vicente. O modelo Reoleo garante o redirecionamento
                        100% limpo para a cadeia de biocombustíveis e saboarias ecológicas.
                        Comece agora mesmo a ajudar a Baixada Santista Ecologicamente.
                    </p>
                </div>
                <div class="col-lg-6 ecosystem-map-column">
                    <div class="map-frame">
                        <img src="<?= base_url('img/img pag 1.1.png') ?>"
                             alt="Mapa da região da Baixada Santista" class="ecosystem-map">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="institutional-section">
        <br>
        <div class="container reoleo-container">
            <div class="row align-items-center institutional-row">
                <div class="col-lg-8">
                    <span class="institutional-eyebrow"><i class="bi bi-mortarboard"></i> INOVAÇÃO E PESQUISA APLICADA</span>
                    <h2>Alinhado às diretrizes metropolitanas e aos Objetivos<br class="desktop-break"> de Desenvolvimento Sustentável (ODS)</h2>
                    <p>
                        Iniciativa conectada a pesquisas tecnológicas de saneamento regional,
                        mitigação de microcontaminantes na costa marinha e fomento à economia
                        circular de biocombustíveis na Baixada Santista.
                    </p>
                </div>
                <div class="col-lg-4 institutional-action d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="<?= base_url('inicioPontoColeta') ?>" class="btn btn-panel">Acessar Painel <i class="bi bi-grid-1x2"></i></a>
                    <a href="<?= base_url('/') ?>" class="btn btn-logout-home"><i class="bi bi-box-arrow-left"></i> Encerrar Sessão</a>
                </div>
            </div>
            <br>
        </div>
    </section>

</main>

<?= $this->include('layouts/footer') ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('js/home.js') ?>"></script>
</body>
</html>