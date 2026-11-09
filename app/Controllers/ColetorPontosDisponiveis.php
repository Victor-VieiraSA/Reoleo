<?php

namespace App\Controllers;

class ColetorPontosDisponiveis extends BaseController
{
    public function index(): string
    {
        return view('coletorPontosDisponiveis/coletorPontosDisponiveis');
    }
}