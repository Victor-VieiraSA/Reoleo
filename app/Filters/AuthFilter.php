<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Protege rotas que exigem login.
 *
 * Uso nas rotas:
 *   'filter' => 'auth'                    qualquer usuário logado
 *   'filter' => 'auth:ponto_coleta'       só esse perfil
 */
class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('auth');

        $usuario = usuario_logado();

        if ($usuario === null) {
            return redirect()->to(base_url('entrar'))
                ->with('aba', 'login')
                ->with('erros_login', ['Faça login para continuar.']);
        }

        if (! empty($arguments) && ! in_array($usuario['perfil'], $arguments, true)) {
            return redirect()->to(base_url(rota_inicial($usuario['perfil'])));
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return null;
    }
}
