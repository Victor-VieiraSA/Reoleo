<?php

namespace App\Libraries;

use Config\Services;
use RuntimeException;
use Throwable;

/**
 * Converte o endereço cadastrado de um ponto de coleta em latitude/longitude,
 * usando o Nominatim (OpenStreetMap). O resultado fica em cache (writable/cache),
 * então cada endereço só é consultado uma vez e o banco não precisa de colunas novas.
 *
 * Política do Nominatim: no máximo 1 consulta por segundo e User-Agent identificado.
 */
class Geocodificador
{
    private const URL = 'https://nominatim.openstreetmap.org/search';

    /** Caixa da Baixada Santista (esquerda, topo, direita, base): evita marcador em outra cidade homônima. */
    private const AREA = '-47.3,-23.6,-45.8,-24.6';

    /** Limite de consultas externas por carregamento de página; o restante é resolvido nas próximas visitas. */
    private const MAX_CONSULTAS = 8;

    private const CACHE_ACERTO = 7776000; // 90 dias
    private const CACHE_FALHA  = 21600;   // 6 horas

    private int $consultas  = 0;
    private float $ultima   = 0.0;

    /**
     * @param array<string,mixed> $usuario precisa de endereco, numero, bairro e municipio
     *
     * @return array{lat:float,lng:float,precisao:string}|null precisao: "endereco" ou "aproximada"
     */
    public function localizar(array $usuario): ?array
    {
        $chave = 'geo_' . md5(mb_strtolower(implode('|', [
            $usuario['endereco'] ?? '', $usuario['numero'] ?? '', $usuario['bairro'] ?? '', $usuario['municipio'] ?? '',
        ])));

        $guardado = cache($chave);

        if (is_array($guardado)) {
            return ($guardado['ok'] ?? false) ? $guardado : null;
        }

        foreach ($this->tentativas($usuario) as [$consulta, $precisao]) {
            if ($this->consultas >= self::MAX_CONSULTAS) {
                return null; // sem cache: tenta de novo na próxima visita
            }

            try {
                $achou = $this->buscar($consulta);
            } catch (Throwable $e) {
                log_message('warning', 'Geocodificação falhou: ' . $e->getMessage());

                return null; // erro de rede não vai para o cache
            }

            if ($achou !== null) {
                $resultado = $achou + ['precisao' => $precisao, 'ok' => true];
                cache()->save($chave, $resultado, self::CACHE_ACERTO);

                return $resultado;
            }
        }

        cache()->save($chave, ['ok' => false], self::CACHE_FALHA);

        return null;
    }

    /**
     * Do mais específico ao mais genérico.
     *
     * @return list<array{0:string,1:string}>
     */
    private function tentativas(array $u): array
    {
        $rua       = trim((string) ($u['endereco'] ?? ''));
        $numero    = trim((string) ($u['numero'] ?? ''));
        $bairro    = trim((string) ($u['bairro'] ?? ''));
        $municipio = trim((string) ($u['municipio'] ?? ''));
        $fim       = $municipio . ', São Paulo, Brasil';

        $t = [];

        if ($rua !== '' && $municipio !== '') {
            $t[] = [trim($rua . ', ' . $numero, ', ') . ($bairro !== '' ? ', ' . $bairro : '') . ', ' . $fim, 'endereco'];
            $t[] = [$rua . ', ' . $fim, 'aproximada'];
        }

        if ($bairro !== '' && $municipio !== '') {
            $t[] = [$bairro . ', ' . $fim, 'aproximada'];
        }

        if ($municipio !== '') {
            $t[] = [$fim, 'aproximada'];
        }

        return $t;
    }

    /** @return array{lat:float,lng:float}|null */
    private function buscar(string $consulta): ?array
    {
        $this->respeitarIntervalo();
        $this->consultas++;

        $resposta = Services::curlrequest(['timeout' => 6, 'http_errors' => false])->get(self::URL, [
            'headers' => [
                'User-Agent'      => 'Reoleo/1.0 (' . base_url() . ')',
                'Accept-Language' => 'pt-BR',
            ],
            'query' => [
                'q'            => $consulta,
                'format'       => 'jsonv2',
                'limit'        => 1,
                'countrycodes' => 'br',
                'viewbox'      => self::AREA,
                'bounded'      => 1,
            ],
        ]);

        if ($resposta->getStatusCode() !== 200) {
            throw new RuntimeException('Nominatim respondeu HTTP ' . $resposta->getStatusCode());
        }

        $dados = json_decode((string) $resposta->getBody(), true);

        if (! is_array($dados) || $dados === [] || ! isset($dados[0]['lat'], $dados[0]['lon'])) {
            return null;
        }

        return ['lat' => (float) $dados[0]['lat'], 'lng' => (float) $dados[0]['lon']];
    }

    private function respeitarIntervalo(): void
    {
        $decorrido = microtime(true) - $this->ultima;

        if ($this->ultima > 0 && $decorrido < 1.1) {
            usleep((int) ((1.1 - $decorrido) * 1_000_000));
        }

        $this->ultima = microtime(true);
    }
}
