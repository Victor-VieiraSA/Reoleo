<?php

namespace App\Controllers;

class MapaDeslogado extends BaseController
{
    public function index(): string
    {
        return view('mapaDeslogado/mapaDeslogado');
    }
}