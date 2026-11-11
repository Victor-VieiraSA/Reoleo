<?php
/**
 * Linhas da tabela "Pontos de Coleta Cadastrados".
 *
 * @var list<array<string,mixed>> $pontos
 */
?>
<?php if (empty($pontos)): ?>
    <tr>
        <td colspan="6" class="text-center text-muted py-5"><?= ! empty($publico) ? 'Nenhum ponto comercial cadastrado ainda. Entre na sua conta para ver todos os pontos da rede.' : 'Nenhum ponto de coleta cadastrado ainda.' ?></td>
    </tr>
<?php endif; ?>

<?php foreach ($pontos as $p): ?>
    <tr data-id="<?= (int) $p['id'] ?>" class="linha-ponto">
        <td class="ps-4">
            <strong class="d-block text-dark"><?= esc($p['nome']) ?></strong>
            <small class="text-muted"><?= esc($p['documento']) ?></small>
        </td>
        <td><span class="badge bg-light text-dark border"><?= esc($p['cidade']) ?></span></td>
        <td><?= esc($p['bairro']) ?></td>
        <td><?= esc($p['endereco']) ?></td>
        <td><span class="badge bg-success-subtle text-success border border-success-subtle">Ativo</span></td>
        <td class="text-end pe-4">
            <?php if ($p['lat'] !== null): ?>
                <button type="button" class="btn btn-sm btn-outline-teal">
                    <i class="bi bi-geo-alt"></i> Ver no Mapa
                </button>
            <?php else: ?>
                <button type="button" class="btn btn-sm btn-outline-secondary" disabled title="Não foi possível localizar este endereço no mapa">
                    <i class="bi bi-geo-alt-fill"></i> Sem localização
                </button>
            <?php endif; ?>
        </td>
    </tr>
<?php endforeach; ?>
