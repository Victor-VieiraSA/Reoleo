<?php
/**
 * Formulário de filtro do histórico (aparece ao clicar em "Filtrar").
 *
 * @var array{status:string,de:string,ate:string} $filtros
 * @var string                                    $acao    URL do painel (GET)
 */
helper('formato');

$ativos = count(array_filter($filtros));
?>
<div class="collapse <?= $ativos > 0 ? 'show' : '' ?>" id="filtroHistorico">
    <form method="get" action="<?= esc($acao, 'attr') ?>" class="px-3 px-md-4 pb-3">
        <div class="row g-2 g-md-3 align-items-end">
            <div class="col-12 col-md-4">
                <label for="filtroStatus" class="form-label small fw-semibold text-dark mb-1">Status</label>
                <select id="filtroStatus" name="status" class="form-select form-select-sm">
                    <option value="">Todos</option>
                    <?php foreach (status_historico() as $st): ?>
                        <option value="<?= esc($st, 'attr') ?>" <?= $filtros['status'] === $st ? 'selected' : '' ?>><?= esc($st) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-6 col-md-3">
                <label for="filtroDe" class="form-label small fw-semibold text-dark mb-1">De</label>
                <input type="date" id="filtroDe" name="de" value="<?= esc($filtros['de'], 'attr') ?>" class="form-control form-control-sm">
            </div>
            <div class="col-6 col-md-3">
                <label for="filtroAte" class="form-label small fw-semibold text-dark mb-1">Até</label>
                <input type="date" id="filtroAte" name="ate" value="<?= esc($filtros['ate'], 'attr') ?>" class="form-control form-control-sm">
            </div>
            <div class="col-12 col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-agendar flex-fill">Aplicar</button>
                <?php if ($ativos > 0): ?>
                    <a href="<?= esc($acao, 'attr') ?>" class="btn btn-sm btn-outline-secondary flex-fill">Limpar</a>
                <?php endif; ?>
            </div>
        </div>
    </form>
</div>
