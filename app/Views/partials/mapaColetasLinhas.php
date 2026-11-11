<?php
/**
 * 
 * 
 * 
 *
 * @var list<array<string,mixed>> $pontos
 */
$linhas = 0;
?>
<?php foreach ($pontos as $p): ?>
    <?php foreach ($p['coletas'] as $c): ?>
        <?php $linhas++; ?>
        <tr data-id="<?= (int) $p['id'] ?>" class="linha-ponto">
            <td class="ps-4">
                <strong class="d-block text-dark"><?= esc($p['nome']) ?></strong>
                <small class="text-muted"><?= esc($p['bairro']) ?> &middot; <?= esc($p['cidade']) ?>/SP</small>
            </td>
            <td><?= esc($c['data']) ?></td>
            <td><?= esc($c['turno']) ?></td>
            <td><span class="badge bg-light text-dark border"><?= esc($c['volume']) ?></span></td>
            <td class="text-end pe-4 text-nowrap">
                <?php if ($p['lat'] === null): ?>
                    <span class="text-muted small me-2" title="Não foi possível localizar este endereço no mapa">Sem localização</span>
                <?php endif; ?>
                <form id="form-solicitar-<?= (int) $c['id'] ?>" method="post"
                      action="<?= base_url('coletor/solicitar/' . (int) $c['id']) ?>" class="d-inline">
                    <?= csrf_field() ?>
                    <input type="hidden" name="origem" value="mapa">
                    <button type="submit" class="btn btn-sm btn-reoleo-primary" onclick="event.stopPropagation()">
                        <i class="bi bi-truck me-1"></i> Solicitar coleta
                    </button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
<?php endforeach; ?>

<?php if ($linhas === 0): ?>
    <tr>
        <td colspan="5" class="text-center text-muted py-5">
            Nenhuma coleta em aberto no momento. Os agendamentos novos dos pontos de coleta aparecem aqui e no mapa.
        </td>
    </tr>
<?php endif; ?>
