<?php

/**
 * Funções de apoio para autenticação.
 * Carregado pelo BaseController (e pelo AuthFilter) com helper('auth').
 */

if (! function_exists('usuario_logado')) {
    /**
     * Retorna os dados do usuário da sessão ou null se ninguém estiver logado.
     */
    function usuario_logado(): ?array
    {
        $usuario = session()->get('usuario');

        return is_array($usuario) ? $usuario : null;
    }
}

if (! function_exists('rota_inicial')) {
    /**
     * Página inicial de cada perfil depois do login.
     */
    function rota_inicial(?string $perfil): string
    {
        return match ($perfil) {
            'ponto_coleta'       => 'inicioPontoColeta',
            'coletor_licenciado' => 'inicioColetor',
            default              => 'entrar',
        };
    }
}

if (! function_exists('rotulo_perfil')) {
    function rotulo_perfil(?string $perfil): string
    {
        return match ($perfil) {
            'ponto_coleta'       => 'Ponto de Coleta',
            'coletor_licenciado' => 'Coletor',
            default              => '',
        };
    }
}

if (! function_exists('rotulo_documento')) {

    function rotulo_documento(?string $documento): string
    {
        return strlen(preg_replace('/\D/', '', (string) $documento)) === 11 ? 'CPF' : 'CNPJ';
    }
}

if (! function_exists('local_usuario')) {

    function local_usuario(): string
    {
        $usuario = usuario_logado();

        if ($usuario === null) {
            return '';
        }

        return trim(($usuario['bairro'] ?? '') . ', ' . ($usuario['municipio'] ?? ''), ', ') . '/SP';
    }
}

if (! function_exists('documento_valido')) {
    /**
     * Valida CPF (11 dígitos) ou CNPJ (14 dígitos), incluindo os dígitos verificadores.
     */
    function documento_valido(?string $documento): bool
    {
        $numeros = preg_replace('/\D/', '', (string) $documento);

        return match (strlen($numeros)) {
            11      => cpf_valido($numeros),
            14      => cnpj_valido($numeros),
            default => false,
        };
    }
}

if (! function_exists('cpf_valido')) {
    function cpf_valido(string $cpf): bool
    {
        $cpf = preg_replace('/\D/', '', $cpf);

        if (strlen($cpf) !== 11 || preg_match('/^(\d)\1{10}$/', $cpf)) {
            return false;
        }

        for ($posicao = 9; $posicao < 11; $posicao++) {
            $soma = 0;

            for ($i = 0; $i < $posicao; $i++) {
                $soma += (int) $cpf[$i] * (($posicao + 1) - $i);
            }

            if ((int) $cpf[$posicao] !== ((10 * $soma) % 11) % 10) {
                return false;
            }
        }

        return true;
    }
}

if (! function_exists('cnpj_valido')) {
    function cnpj_valido(string $cnpj): bool
    {
        $cnpj = preg_replace('/\D/', '', $cnpj);

        if (strlen($cnpj) !== 14 || preg_match('/^(\d)\1{13}$/', $cnpj)) {
            return false;
        }

        foreach ([12, 13] as $posicao) {
            $pesos = $posicao === 12
                ? [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2]
                : [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

            $soma = 0;

            for ($i = 0; $i < $posicao; $i++) {
                $soma += (int) $cnpj[$i] * $pesos[$i];
            }

            $resto = $soma % 11;
            $digito = $resto < 2 ? 0 : 11 - $resto;

            if ((int) $cnpj[$posicao] !== $digito) {
                return false;
            }
        }

        return true;
    }
}

if (! function_exists('atributos_sair')) {
    /**
     * Atributos para um link "Encerrar sessão": o clique envia um POST com o
     * token CSRF para /sair, sem precisar de um <form> na página.
     *
     * Uso: <a href="<?= base_url('sair') ?>" class="btn-logout" <?= atributos_sair() ?>>
     */
    function atributos_sair(): string
    {
        $js = "event.preventDefault();"
            . "var f=document.createElement('form');f.method='post';f.action=this.href;"
            . "var i=document.createElement('input');i.type='hidden';"
            . "i.name=this.dataset.csrfName;i.value=this.dataset.csrfHash;"
            . "f.appendChild(i);document.body.appendChild(f);f.submit();";

        return 'data-csrf-name="' . esc(csrf_token(), 'attr') . '" '
            . 'data-csrf-hash="' . esc(csrf_hash(), 'attr') . '" '
            . 'onclick="' . esc($js, 'attr') . '"';
    }
}
