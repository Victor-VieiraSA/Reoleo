<?php

namespace App\Libraries;

use App\Models\AgendamentoModel;
use App\Models\UsuarioModel;

/**
 * Monta a lista de pontos de coleta cadastrados para as telas de mapa.
 */
class PontosMapa
{
    /**
     * @param bool $publico true na página sem login: só pontos com CNPJ e sem dados de contato
     *
     * @return list<array<string,mixed>>
     */
    public function listar(bool $publico): array
    {
        helper('formato');

        $usuarios = model(UsuarioModel::class)
            ->select('id, razao_social, cpf_cnpj, telefone, email, endereco, numero, bairro, municipio')
            ->where('perfil', 'ponto_coleta')
            ->orderBy('razao_social', 'ASC')
            ->findAll();

        $geocodificador = new Geocodificador();
        $pontos         = [];

        foreach ($usuarios as $u) {
            $ehCnpj = strlen((string) preg_replace('/\D/', '', (string) $u['cpf_cnpj'])) === 14;

            if ($publico && ! $ehCnpj) {
                continue;
            }

            $coord = $geocodificador->localizar($u);

            $pontos[] = [
                'id'        => (int) $u['id'],
                'nome'      => (string) $u['razao_social'],
                'cidade'    => (string) $u['municipio'],
                'bairro'    => (string) $u['bairro'],
                'endereco'  => trim($u['endereco'] . ', ' . $u['numero'], ', '),
                'tipo'      => $ehCnpj ? 'Ponto Comercial Cadastrado' : 'Ponto de Coleta Cadastrado',
                // CPF nunca é exibido: só o CNPJ (dado de empresa).
                'documento' => $ehCnpj ? 'CNPJ ' . formatar_documento($u['cpf_cnpj']) : 'Pessoa física',
                'contato'   => $publico ? '' : (string) (($u['telefone'] ?? '') !== '' ? $u['telefone'] : $u['email']),
                'lat'       => $coord['lat'] ?? null,
                'lng'       => $coord['lng'] ?? null,
                'precisao'  => $coord['precisao'] ?? null,
            ];
        }

        return $pontos;
    }

    /**
     * Mapa do coletor: só os pontos que têm agendamento aberto (Pendente, sem coletor e com
     * data de hoje em diante, a mesma regra de AgendamentoModel::disponiveis). Cada ponto
     * traz a lista dessas coletas em "coletas", da mais próxima para a mais distante.
     *
     * @return list<array<string,mixed>>
     */
    public function comColetaAberta(): array
    {
        helper('formato');

        $geocodificador = new Geocodificador();
        $pontos         = [];

        foreach (model(AgendamentoModel::class)->disponiveis() as $a) {
            $id = (int) $a['usuario_id'];

            if (! isset($pontos[$id])) {
                $coord  = $geocodificador->localizar([
                    'endereco'  => $a['ponto_endereco'],
                    'numero'    => $a['ponto_numero'],
                    'bairro'    => $a['ponto_bairro'],
                    'municipio' => $a['ponto_municipio'],
                ]);
                $ehCnpj = strlen((string) preg_replace('/\D/', '', (string) $a['ponto_documento'])) === 14;

                $pontos[$id] = [
                    'id'        => $id,
                    'nome'      => (string) $a['ponto_nome'],
                    'cidade'    => (string) $a['ponto_municipio'],
                    'bairro'    => (string) $a['ponto_bairro'],
                    'endereco'  => trim($a['ponto_endereco'] . ', ' . $a['ponto_numero'], ', '),
                    'tipo'      => '',
                    // CPF nunca é exibido: só o CNPJ (dado de empresa).
                    'documento' => $ehCnpj ? 'CNPJ ' . formatar_documento($a['ponto_documento']) : 'Pessoa física',
                    'contato'   => (string) (($a['ponto_telefone'] ?? '') !== '' ? $a['ponto_telefone'] : $a['ponto_email']),
                    'lat'       => $coord['lat'] ?? null,
                    'lng'       => $coord['lng'] ?? null,
                    'precisao'  => $coord['precisao'] ?? null,
                    'coletas'   => [],
                ];
            }

            $curta = data_curta($a['data_coleta']);

            $pontos[$id]['coletas'][] = [
                'id'          => (int) $a['id'],
                // "Hoje, 11 de Nov" / "Amanhã, ..." já dizem o dia; nas demais datas entra o dia da semana.
                'data'        => str_contains($curta, ',') ? $curta : dia_semana_abrev($a['data_coleta']) . ' ' . $curta,
                'turno'       => turno_detalhe($a['turno']),
                'volume'      => (string) $a['volume_estimado'],
                'observacoes' => (string) ($a['observacoes'] ?? ''),
            ];
        }

        foreach ($pontos as &$p) {
            $total    = count($p['coletas']);
            $p['tipo'] = $total === 1 ? '1 coleta aberta' : $total . ' coletas abertas';
        }
        unset($p);

        return array_values($pontos);
    }
}
