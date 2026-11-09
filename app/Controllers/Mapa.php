<?php

namespace App\Controllers;

class Mapa extends BaseController
{
    public function index(): string
    {
        return view('mapa/mapa');
    }
}