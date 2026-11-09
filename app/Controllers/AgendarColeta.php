<?php

namespace App\Controllers;

class AgendarColeta extends BaseController
{
    public function index(): string
    {
        return view('agendarColeta/agendarColeta');
    }
}