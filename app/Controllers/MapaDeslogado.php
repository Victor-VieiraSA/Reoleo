<?php

namespace App\Controllers;

use App\Libraries\PontosMapa;

class MapaDeslogado extends BaseController
{
    public function index(): string
    {
        return view('mapaDeslogado/mapaDeslogado', [
            'pontos'  => (new PontosMapa())->listar(true),
            'publico' => true,
        ]);
    }
}
