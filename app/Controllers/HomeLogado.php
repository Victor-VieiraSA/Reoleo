<?php

namespace App\Controllers;

class HomeLogado extends BaseController
{
    public function index(): string
    {
        return view('homeLogado/homeLogado');
    }
}