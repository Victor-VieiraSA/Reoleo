<?php

/**
 * Funções de formatação usadas nas telas de agendamento.
 * Carregar com helper('formato').
 */

if (! function_exists('formatar_documento')) {
    /** 00000000000 => 000.000.000-00 | 00000000000000 => 00.000.000/0000-00 */
    function formatar_documento(?string $documento): string
    {
        $n = preg_replace('/\D/', '', (string) $documento);

        return match (strlen($n)) {
            11      => substr($n, 0, 3) . '.' . substr($n, 3, 3) . '.' . substr($n, 6, 3) . '-' . substr($n, 9),
            14      => substr($n, 0, 2) . '.' . substr($n, 2, 3) . '.' . substr($n, 5, 3) . '/' . substr($n, 8, 4) . '-' . substr($n, 12),
            default => (string) $documento,
        };
    }
}

if (! function_exists('dia_semana_abrev')) {
    function dia_semana_abrev(string $dataYmd): string
    {
        $dias = ['Dom.', 'Seg.', 'Ter.', 'Qua.', 'Qui.', 'Sex.', 'Sáb.'];

        return $dias[(int) date('w', strtotime($dataYmd))];
    }
}

if (! function_exists('data_curta')) {
    /** 2026-11-24 => "24 de Nov" (com "Hoje, " na frente se for hoje). */
    function data_curta(string $dataYmd): string
    {
        $meses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
        $ts    = strtotime($dataYmd);
        $texto = date('j', $ts) . ' de ' . $meses[(int) date('n', $ts) - 1];

        if ($dataYmd === date('Y-m-d')) {
            return 'Hoje, ' . $texto;
        }

        return $dataYmd === date('Y-m-d', strtotime('+1 day')) ? 'Amanhã, ' . $texto : $texto;
    }
}

if (! function_exists('turno_detalhe')) {
    function turno_detalhe(?string $turno): string
    {
        return match ($turno) {
            'Manhã' => 'Turno Manhã (08h - 12h)',
            'Tarde' => 'Turno Tarde (13h - 18h)',
            default => (string) $turno,
        };
    }
}

if (! function_exists('classe_status')) {
    function classe_status(?string $status): string
    {
        return match ($status) {
            'Confirmado' => 'badge-status-confirmado',
            'Concluído'  => 'badge-status-concluido',
            'Cancelado'  => 'badge-status-cancelado',
            default      => 'badge-status-pendente',
        };
    }
}


if (! function_exists('litros_estimados')) {
    /**
     * Litros aproximados de uma faixa de volume estimado.
     * Usa o ponto médio da faixa; "Mais de 100 Litros" usa o mínimo (100).
     */
    function litros_estimados(?string $volume): int
    {
        return match ($volume) {
            'Até 20 Litros'      => 10,
            '20 a 50 Litros'     => 35,
            '50 a 100 Litros'    => 75,
            'Mais de 100 Litros' => 100,
            default              => 0,
        };
    }
}

if (! function_exists('total_litros')) {
    /** Soma os litros estimados de uma lista de agendamentos. */
    function total_litros(array $agendamentos): int
    {
        return array_sum(array_map(
            static fn (array $a): int => litros_estimados($a['volume_estimado'] ?? null),
            $agendamentos
        ));
    }
}

if (! function_exists('status_historico')) {
    /** Status que podem ser usados no filtro do histórico. */
    function status_historico(): array
    {
        return ['Pendente', 'Confirmado', 'Concluído', 'Cancelado'];
    }
}

if (! function_exists('filtros_historico')) {
    /**
     * Lê e valida os filtros (status, de, ate) vindos da URL.
     * Valores inválidos viram string vazia; datas invertidas são trocadas.
     *
     * @return array{status:string,de:string,ate:string}
     */
    function filtros_historico(array $get): array
    {
        $dataValida = static function (mixed $valor): string {
            $valor = (string) $valor;
            $data  = DateTime::createFromFormat('Y-m-d', $valor);

            return ($data && $data->format('Y-m-d') === $valor) ? $valor : '';
        };

        $status  = (string) ($get['status'] ?? '');
        $filtros = [
            'status' => in_array($status, status_historico(), true) ? $status : '',
            'de'     => $dataValida($get['de'] ?? ''),
            'ate'    => $dataValida($get['ate'] ?? ''),
        ];

        if ($filtros['de'] !== '' && $filtros['ate'] !== '' && $filtros['de'] > $filtros['ate']) {
            [$filtros['de'], $filtros['ate']] = [$filtros['ate'], $filtros['de']];
        }

        return $filtros;
    }
}
