<?php

namespace App\Controllers;

class InicioPontoColeta extends BaseController
{
    public function index(): string
    {
        return view('inicioPontoColeta/inicioPontoColeta');
    }
}