<?php
/**
 * 
 * 
 *
 * @var list<array<string,mixed>> $pontos
 * @var bool                      $publico
 */
$json = json_encode(
    $pontos,
    JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_PARTIAL_OUTPUT_ON_ERROR
);
?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const mapElement = document.getElementById('mapa-reoleo-interativo');
    if (!mapElement) return;

    const publico = <?= $publico ? 'true' : 'false' ?>;
    const coletorMode = <?= ($modo ?? 'rede') === 'coletor' ? 'true' : 'false' ?>;
    const infoColetas = document.getElementById('info-coletas');
    const pontos = <?= $json ?: '[]' ?>;

    const mapa = L.map('mapa-reoleo-interativo').setView([-23.9608, -46.3339], 11);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener">OpenStreetMap</a> contributors'
    }).addTo(mapa);

    setTimeout(function () {
        mapa.invalidateSize();
    }, 200);

    const escapar = (texto) => String(texto ?? '').replace(/[&<>"']/g, (c) => (
        { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]
    ));

    const placeholder = document.getElementById('detalhes-placeholder');
    const conteudo = document.getElementById('detalhes-conteudo');
    const infoNome = document.getElementById('info-nome');
    const infoCidade = document.getElementById('info-cidade');
    const infoTipo = document.getElementById('info-tipo');
    const infoContato = document.getElementById('info-contato');
    const infoEndereco = document.getElementById('info-endereco');
    const infoDocumento = document.getElementById('info-documento');

    const marcadoresMap = {};

    function selecionarPonto(ponto, moverMapa = true) {
        placeholder.classList.add('d-none');
        conteudo.classList.remove('d-none');

        infoNome.innerText = ponto.nome;
        infoCidade.innerText = `${ponto.cidade}/SP`;
        infoTipo.innerText = ponto.tipo;
        infoContato.innerText = ponto.contato || (publico ? 'Entre na sua conta para ver o contato' : 'Não informado');
        infoEndereco.innerText = `${ponto.endereco} - ${ponto.bairro}`;
        infoDocumento.innerText = ponto.documento;

        if (infoColetas) {
            const coletas = coletorMode && Array.isArray(ponto.coletas) ? ponto.coletas : [];

            infoColetas.classList.toggle('d-none', coletas.length === 0);
            infoColetas.innerHTML = coletas.length === 0 ? '' : `
                <span class="text-uppercase fw-bold text-muted extra-small d-block mb-2">Coletas abertas neste ponto</span>
                ${coletas.map((c) => `
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 border rounded-3 p-2 mb-2">
                        <div>
                            <strong class="text-dark">${escapar(c.data)}</strong>
                            <span class="text-muted small"> &middot; ${escapar(c.turno)} &middot; ${escapar(c.volume)}</span>
                            ${c.observacoes ? `<div class="text-muted extra-small">${escapar(c.observacoes)}</div>` : ''}
                        </div>
                        <button type="button" class="btn btn-sm btn-reoleo-primary" data-solicitar="${Number(c.id)}">
                            <i class="bi bi-truck me-1"></i> Solicitar coleta
                        </button>
                    </div>
                `).join('')}
            `;
        }

        document.querySelectorAll('.linha-ponto').forEach((tr) => tr.classList.remove('linha-selecionada'));
        const linhaAlvo = document.querySelector(`.linha-ponto[data-id="${ponto.id}"]`);
        if (linhaAlvo) {
            linhaAlvo.classList.add('linha-selecionada');
        }

        if (moverMapa && marcadoresMap[ponto.id]) {
            mapa.setView([ponto.lat, ponto.lng], 15, { animate: true });
            setTimeout(() => marcadoresMap[ponto.id].openPopup(), 150);
        }
    }

    const limites = [];

    pontos.forEach((ponto) => {
        if (ponto.lat === null || ponto.lng === null) return;

        const marker = L.marker([ponto.lat, ponto.lng]).addTo(mapa);
        marcadoresMap[ponto.id] = marker;
        limites.push([ponto.lat, ponto.lng]);

        marker.bindPopup(`
            <div class="popup-reoleo">
                <span class="popup-badge">${escapar(ponto.tipo)}</span>
                <h6 class="fw-bold text-dark mb-1 mt-2">${escapar(ponto.nome)}</h6>
                <p class="text-muted extra-small mb-0">${escapar(ponto.bairro)} - ${escapar(ponto.cidade)}/SP</p>
                ${coletorMode && ponto.coletas && ponto.coletas.length ? `<p class="text-dark extra-small mb-0 mt-1"><strong>Próxima:</strong> ${escapar(ponto.coletas[0].data)} &middot; ${escapar(ponto.coletas[0].turno)}</p>` : ''}
                ${ponto.precisao === 'aproximada' ? '<p class="text-muted extra-small mb-0 mt-1"><i>Localização aproximada</i></p>' : ''}
            </div>
        `);

        marker.on('click', () => selecionarPonto(ponto, false));
    });

    if (limites.length > 0) {
        mapa.fitBounds(L.latLngBounds(limites), { padding: [40, 40], maxZoom: 14 });
    }

    document.querySelectorAll('.linha-ponto').forEach((linha) => {
        linha.addEventListener('click', function () {
            const id = parseInt(this.getAttribute('data-id'), 10);
            const ponto = pontos.find((p) => p.id === id);
            if (!ponto) return;

            if (ponto.lat !== null) {
                mapElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            selecionarPonto(ponto, ponto.lat !== null);
        });
    });

    // Botões "Solicitar coleta" do painel: enviam o formulário (POST + CSRF) da linha da tabela.
    if (infoColetas) {
        infoColetas.addEventListener('click', (evento) => {
            const botao = evento.target.closest('[data-solicitar]');
            if (!botao) return;

            const form = document.getElementById(`form-solicitar-${botao.dataset.solicitar}`);
            if (form) {
                botao.disabled = true;
                form.requestSubmit();
            }
        });
    }

    document.getElementById('inputBusca').addEventListener('keyup', function () {
        const termo = this.value.toLowerCase();

        document.querySelectorAll('#tabelaPontos tbody tr').forEach((linha) => {
            linha.style.display = linha.innerText.toLowerCase().includes(termo) ? '' : 'none';
        });
    });
});
</script>
