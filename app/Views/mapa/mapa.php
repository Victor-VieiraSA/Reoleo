<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reoleo | Mapa de Pontos de Coleta</title>
    <meta name="description" content="Explore e localize os pontos de coleta de óleo vegetal cadastrados na Baixada Santista.">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- CSS oficial do Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <link rel="stylesheet" href="<?= base_url('css/home.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/header.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/footer.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/mapaView.css') ?>">
</head>
<body>

<div class="site-wrapper">

    <?= $this->include('layouts/headerLogado') ?>

    <main class="reoleo-home py-4 py-md-5">
        <div class="container reoleo-container">
            
            <!-- Cabeçalho da Página -->
            <div class="mapa-header-section mb-4">
                <span class="region-badge mb-2"><i class="bi bi-geo-alt-fill"></i> GEOLOCALIZAÇÃO REGIONAL</span>
                <h1 class="fw-bold text-dark m-0">Rede de Pontos de Coleta</h1>
                <p class="text-muted mt-2 mb-0 mapa-descricao">
                    Navegue pelo mapa interativo e encontre os estabelecimentos parceiros na Baixada Santista. 
                    Escolha o ponto mais próximo de você para agendar o recolhimento sustentável do óleo usado.
                </p>
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
                        <span class="small">Clique em qualquer marcador no mapa acima para visualizar o responsável, endereço e dados de cadastro.</span>
                    </div>
                </div>

                <div class="d-none" id="detalhes-conteudo">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 border-bottom pb-3 mb-3">
                        <div>
                            <span class="badge-region mb-1" id="info-cidade">Santos/SP</span>
                            <h3 class="fw-bold text-dark m-0" id="info-nome">Restaurante Estrela</h3>
                            <span class="text-muted extra-small" id="info-tipo">Ponto Comercial Cadastrado</span>
                        </div>
                        <a href="<?= base_url('Agendar') ?>" class="btn btn-reoleo-primary">
                            <i class="bi bi-calendar-check me-1"></i> Agendar Coleta Neste Ponto
                        </a>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <span class="text-uppercase fw-bold text-muted extra-small d-block">Responsável / Cadastrante</span>
                            <strong class="text-dark fs-6" id="info-responsavel">Carlos Eduardo (Gerente)</strong>
                        </div>
                        <div class="col-md-4">
                            <span class="text-uppercase fw-bold text-muted extra-small d-block">Endereço Operacional</span>
                            <span class="text-dark font-semibold" id="info-endereco">Av. Ana Costa, 150 - Vila Mathias</span>
                        </div>
                        <div class="col-md-4">
                            <span class="text-uppercase fw-bold text-muted extra-small d-block">Documento / Registro</span>
                            <span class="badge-cnpj" id="info-cnpj">CNPJ 00.000.000/0001-00</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Seção da Tabela com Bootstrap Padrão -->
            <div class="tabela-secao mt-5">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                    <div>
                        <span class="eyebrow">REGISTROS DA REDE</span>
                        <h2 class="fw-bold text-dark m-0">Pontos de Coleta Cadastrados</h2>
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
                                <tr>
                                    <th class="ps-4">Estabelecimento / Ponto</th>
                                    <th>Município</th>
                                    <th>Bairro</th>
                                    <th>Responsável</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr data-id="0" class="linha-ponto">
                                    <td class="ps-4">
                                        <strong class="d-block text-dark">Restaurante Estrela</strong>
                                        <small class="text-muted">CNPJ 12.345.678/0001-90</small>
                                    </td>
                                    <td><span class="badge bg-light text-dark border">Santos</span></td>
                                    <td>Vila Mathias</td>
                                    <td>Carlos Eduardo</td>
                                    <td><span class="badge bg-success-subtle text-success border border-success-subtle">Ativo</span></td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-outline-teal">
                                            <i class="bi bi-geo-alt"></i> Ver no Mapa
                                        </button>
                                    </td>
                                </tr>
                                <tr data-id="1" class="linha-ponto">
                                    <td class="ps-4">
                                        <strong class="d-block text-dark">Ecoponto São Vicente</strong>
                                        <small class="text-muted">Posto Público Municipal</small>
                                    </td>
                                    <td><span class="badge bg-light text-dark border">São Vicente</span></td>
                                    <td>Centro</td>
                                    <td>Secretaria de Meio Ambiente</td>
                                    <td><span class="badge bg-success-subtle text-success border border-success-subtle">Ativo</span></td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-outline-teal">
                                            <i class="bi bi-geo-alt"></i> Ver no Mapa
                                        </button>
                                    </td>
                                </tr>
                                <tr data-id="2" class="linha-ponto">
                                    <td class="ps-4">
                                        <strong class="d-block text-dark">Ponto Coleta Enseada</strong>
                                        <small class="text-muted">CNPJ 98.765.432/0001-10</small>
                                    </td>
                                    <td><span class="badge bg-light text-dark border">Guarujá</span></td>
                                    <td>Enseada</td>
                                    <td>Mariana Silva</td>
                                    <td><span class="badge bg-success-subtle text-success border border-success-subtle">Ativo</span></td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-outline-teal">
                                            <i class="bi bi-geo-alt"></i> Ver no Mapa
                                        </button>
                                    </td>
                                </tr>
                                <tr data-id="3" class="linha-ponto">
                                    <td class="ps-4">
                                        <strong class="d-block text-dark">Coleta Boqueirão PG</strong>
                                        <small class="text-muted">CNPJ 45.678.910/0001-22</small>
                                    </td>
                                    <td><span class="badge bg-light text-dark border">Praia Grande</span></td>
                                    <td>Boqueirão</td>
                                    <td>Roberto Lima</td>
                                    <td><span class="badge bg-success-subtle text-success border border-success-subtle">Ativo</span></td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-outline-teal">
                                            <i class="bi bi-geo-alt"></i> Ver no Mapa
                                        </button>
                                    </td>
                                </tr>
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

<script>
document.addEventListener("DOMContentLoaded", function () {
    const mapElement = document.getElementById('mapa-reoleo-interativo');
    if (!mapElement) return;

    const mapa = L.map('mapa-reoleo-interativo').setView([-23.9608, -46.3339], 11);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; Reoleo Baixada Santista'
    }).addTo(mapa);

    setTimeout(function() {
        mapa.invalidateSize();
    }, 200);

    const pontosEstaticos = [
        {
            id: 0,
            nome: "Restaurante Estrela",
            cidade: "Santos",
            bairro: "Vila Mathias",
            endereco: "Av. Ana Costa, 150",
            tipo: "Ponto Comercial Cadastrado",
            responsavel: "Carlos Eduardo (Gerente)",
            documento: "CNPJ 12.345.678/0001-90",
            lat: -23.9558,
            lng: -46.3315
        },
        {
            id: 1,
            nome: "Ecoponto São Vicente",
            cidade: "São Vicente",
            bairro: "Centro",
            endereco: "Rua Cândido Rodrigues, 88",
            tipo: "Posto Público Municipal",
            responsavel: "Sec. Meio Ambiente",
            documento: "Gestão Pública",
            lat: -23.9631,
            lng: -46.3919
        },
        {
            id: 2,
            nome: "Ponto Coleta Enseada",
            cidade: "Guarujá",
            bairro: "Enseada",
            endereco: "Av. Dom Pedro I, 1200",
            tipo: "Ponto Comercial Cadastrado",
            responsavel: "Mariana Silva",
            documento: "CNPJ 98.765.432/0001-10",
            lat: -23.9850,
            lng: -46.2350
        },
        {
            id: 3,
            nome: "Coleta Boqueirão PG",
            cidade: "Praia Grande",
            bairro: "Boqueirão",
            endereco: "Av. Costa e Silva, 450",
            tipo: "Ponto Comercial Cadastrado",
            responsavel: "Roberto Lima",
            documento: "CNPJ 45.678.910/0001-22",
            lat: -24.0058,
            lng: -46.4131
        }
    ];

    const placeholder = document.getElementById('detalhes-placeholder');
    const conteudo = document.getElementById('detalhes-conteudo');
    const infoNome = document.getElementById('info-nome');
    const infoCidade = document.getElementById('info-cidade');
    const infoTipo = document.getElementById('info-tipo');
    const infoResponsavel = document.getElementById('info-responsavel');
    const infoEndereco = document.getElementById('info-endereco');
    const infoCnpj = document.getElementById('info-cnpj');

    const marcadoresMap = {};

    function selecionarPonto(ponto, moverMapa = true) {
        placeholder.classList.add('d-none');
        conteudo.classList.remove('d-none');

        infoNome.innerText = ponto.nome;
        infoCidade.innerText = `${ponto.cidade}/SP`;
        infoTipo.innerText = ponto.tipo;
        infoResponsavel.innerText = ponto.responsavel;
        infoEndereco.innerText = `${ponto.endereco} - ${ponto.bairro}`;
        infoCnpj.innerText = ponto.documento;

        document.querySelectorAll('.linha-ponto').forEach(tr => tr.classList.remove('linha-selecionada'));
        const linhaAlvo = document.querySelector(`.linha-ponto[data-id="${ponto.id}"]`);
        if (linhaAlvo) {
            linhaAlvo.classList.add('linha-selecionada');
        }

        if (moverMapa && marcadoresMap[ponto.id]) {
            mapa.setView([ponto.lat, ponto.lng], 14, { animate: true });
            setTimeout(() => {
                marcadoresMap[ponto.id].openPopup();
            }, 150);
        }
    }

    pontosEstaticos.forEach(ponto => {
        const marker = L.marker([ponto.lat, ponto.lng]).addTo(mapa);
        marcadoresMap[ponto.id] = marker;
        
        marker.bindPopup(`
            <div class="popup-reoleo">
                <span class="popup-badge">${ponto.tipo}</span>
                <h6 class="fw-bold text-dark mb-1 mt-2">${ponto.nome}</h6>
                <p class="text-muted extra-small mb-0">${ponto.bairro} - ${ponto.cidade}/SP</p>
            </div>
        `);

        marker.on('click', function () {
            selecionarPonto(ponto, false);
        });
    });

    document.querySelectorAll('.linha-ponto').forEach(linha => {
        linha.addEventListener('click', function () {
            const id = parseInt(this.getAttribute('data-id'));
            const ponto = pontosEstaticos.find(p => p.id === id);
            if (ponto) {
                document.getElementById('mapa-reoleo-interativo').scrollIntoView({ behavior: 'smooth', block: 'center' });
                selecionarPonto(ponto, true);
            }
        });
    });

    document.getElementById('inputBusca').addEventListener('keyup', function () {
        const termo = this.value.toLowerCase();
        const linhas = document.querySelectorAll('#tabelaPontos tbody tr');

        linhas.forEach(linha => {
            const texto = linha.innerText.toLowerCase();
            linha.style.display = texto.includes(termo) ? '' : 'none';
        });
    });
});
</script>
</body>
</html>