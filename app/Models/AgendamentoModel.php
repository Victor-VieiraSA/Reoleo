<?php

namespace App\Models;

use CodeIgniter\Model;

class AgendamentoModel extends Model
{
    protected $table         = 'agendamentos';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false; // `criado_em` é preenchido pelo próprio banco

    protected $allowedFields = [
        'usuario_id',
        'coletor_id',
        'data_coleta',
        'turno',
        'volume_estimado',
        'observacoes',
        'status',
    ];

    /**
     * Agendamentos de um ponto de coleta, com o nome do coletor (se já houver).
     *
     * @return list<array<string,mixed>>
     */
    public function doUsuario(int $usuarioId, array $filtros = []): array
    {
        $this->aplicarFiltros($filtros);

        return $this->select('agendamentos.*, coletor.razao_social AS coletor_nome')
            ->join('usuarios AS coletor', 'coletor.id = agendamentos.coletor_id', 'left')
            ->where('agendamentos.usuario_id', $usuarioId)
            ->orderBy('agendamentos.data_coleta', 'DESC')
            ->orderBy('agendamentos.id', 'DESC')
            ->findAll();
    }

    /**
     * Solicitações abertas: pendentes, sem coletor e com data de hoje em diante.
     *
     * @return list<array<string,mixed>>
     */
    public function disponiveis(): array
    {
        return $this->selectComPonto()
            ->where('agendamentos.status', 'Pendente')
            ->where('agendamentos.coletor_id IS NULL', null, false)
            ->where('agendamentos.data_coleta >=', date('Y-m-d'))
            ->orderBy('agendamentos.data_coleta', 'ASC')
            ->orderBy('agendamentos.id', 'ASC')
            ->findAll();
    }

    /**
     * Coletas que um coletor aceitou (qualquer status), com os dados do ponto.
     *
     * @return list<array<string,mixed>>
     */
    public function doColetor(int $coletorId, array $filtros = []): array
    {
        $this->aplicarFiltros($filtros);

        return $this->selectComPonto()
            ->where('agendamentos.coletor_id', $coletorId)
            ->orderBy('agendamentos.data_coleta', 'DESC')
            ->orderBy('agendamentos.id', 'DESC')
            ->findAll();
    }

    /**
     * O coletor solicita uma coleta. Ela segue Pendente (agora com coletor) até o ponto
     * de coleta aceitar ou recusar. A condição "ainda sem coletor" vai dentro do próprio
     * UPDATE, então se dois coletores clicarem ao mesmo tempo só um consegue.
     */
    public function solicitar(int $id, int $coletorId): bool
    {
        $this->db->table($this->table)
            ->where('id', $id)
            ->where('status', 'Pendente')
            ->where('coletor_id IS NULL', null, false)
            ->where('data_coleta >=', date('Y-m-d'))
            ->update(['coletor_id' => $coletorId]);

        return $this->db->affectedRows() === 1;
    }

    /** Marca como concluída uma coleta confirmada que pertence ao coletor. */
    public function finalizar(int $id, int $coletorId): bool
    {
        $this->db->table($this->table)
            ->where('id', $id)
            ->where('coletor_id', $coletorId)
            ->where('status', 'Confirmado')
            ->update(['status' => 'Concluído']);

        return $this->db->affectedRows() === 1;
    }

    /** O coletor desiste (ou cancela a solicitação): a coleta volta a ficar disponível para outros. */
    public function liberar(int $id, int $coletorId): bool
    {
        $this->db->table($this->table)
            ->where('id', $id)
            ->where('coletor_id', $coletorId)
            ->whereIn('status', ['Pendente', 'Confirmado'])
            ->update(['coletor_id' => null, 'status' => 'Pendente']);

        return $this->db->affectedRows() === 1;
    }

    /** Um agendamento do ponto de coleta (null se não existir ou for de outro usuário). */
    public function doUsuarioPorId(int $id, int $usuarioId): ?array
    {
        return $this->where('id', $id)->where('usuario_id', $usuarioId)->first();
    }

    /** Edita data, turno, volume e observações. Só vale enquanto está Pendente e sem coletor. */
    public function editar(int $id, int $usuarioId, array $dados): bool
    {
        return $this->db->table($this->table)
            ->where('id', $id)
            ->where('usuario_id', $usuarioId)
            ->where('status', 'Pendente')
            ->where('coletor_id IS NULL', null, false)
            ->update([
                'data_coleta'     => $dados['data_coleta'],
                'turno'           => $dados['turno'],
                'volume_estimado' => $dados['volume_estimado'],
                'observacoes'     => $dados['observacoes'],
            ]);
    }

    /** Apaga um agendamento que ainda está Pendente e sem coletor. */
    public function excluir(int $id, int $usuarioId): bool
    {
        $this->db->table($this->table)
            ->where('id', $id)
            ->where('usuario_id', $usuarioId)
            ->where('status', 'Pendente')
            ->where('coletor_id IS NULL', null, false)
            ->delete();

        return $this->db->affectedRows() === 1;
    }

    /** Cancela um agendamento que já foi aceito por um coletor (fica no histórico como Cancelado). */
    public function cancelar(int $id, int $usuarioId): bool
    {
        $this->db->table($this->table)
            ->where('id', $id)
            ->where('usuario_id', $usuarioId)
            ->where('status', 'Confirmado')
            ->update(['status' => 'Cancelado']);

        return $this->db->affectedRows() === 1;
    }

    /** O ponto de coleta aceita o coletor que solicitou: Pendente -> Confirmado. */
    public function aceitarColetor(int $id, int $usuarioId): bool
    {
        $this->db->table($this->table)
            ->where('id', $id)
            ->where('usuario_id', $usuarioId)
            ->where('status', 'Pendente')
            ->where('coletor_id IS NOT NULL', null, false)
            ->update(['status' => 'Confirmado']);

        return $this->db->affectedRows() === 1;
    }

    /** O ponto de coleta recusa o coletor: volta a ficar sem coletor e disponível para outros. */
    public function recusarColetor(int $id, int $usuarioId): bool
    {
        $this->db->table($this->table)
            ->where('id', $id)
            ->where('usuario_id', $usuarioId)
            ->where('status', 'Pendente')
            ->where('coletor_id IS NOT NULL', null, false)
            ->update(['coletor_id' => null]);

        return $this->db->affectedRows() === 1;
    }

    /** Aplica status e intervalo de datas (já validados por filtros_historico). */
    private function aplicarFiltros(array $filtros): void
    {
        if (! empty($filtros['status'])) {
            $this->where('agendamentos.status', $filtros['status']);
        }

        if (! empty($filtros['de'])) {
            $this->where('agendamentos.data_coleta >=', $filtros['de']);
        }

        if (! empty($filtros['ate'])) {
            $this->where('agendamentos.data_coleta <=', $filtros['ate']);
        }
    }

    private function selectComPonto(): static
    {
        return $this->select(
            'agendamentos.*, ponto.razao_social AS ponto_nome, ponto.endereco AS ponto_endereco, '
            . 'ponto.numero AS ponto_numero, ponto.bairro AS ponto_bairro, ponto.municipio AS ponto_municipio, '
            . 'ponto.cpf_cnpj AS ponto_documento, ponto.telefone AS ponto_telefone, ponto.email AS ponto_email'
        )->join('usuarios AS ponto', 'ponto.id = agendamentos.usuario_id');
    }
}
