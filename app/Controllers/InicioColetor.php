<?php

namespace App\Controllers;

class InicioColetor extends BaseController
{
    public function index(): string
    {
        return view('inicioColetor/inicioColetor');
    }
}