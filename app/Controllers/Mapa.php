<?php

namespace App\Controllers;

use App\Libraries\PontosMapa;

class Mapa extends BaseController
{
    protected $helpers = ['auth', 'formato'];

    public function index(): string
    {
        $ehColetor = (usuario_logado()['perfil'] ?? '') === 'coletor_licenciado';
        $pontos    = new PontosMapa();
        $sessao    = session();

        return view('mapa/mapa', [
            'pontos'  => $ehColetor ? $pontos->comColetaAberta() : $pontos->listar(false),
            'publico' => false,
            'modo'    => $ehColetor ? 'coletor' : 'rede',
            'sucesso' => $sessao->getFlashdata('sucesso') ?? '',
            'erro'    => $sessao->getFlashdata('erro') ?? '',
        ]);
    }
}
