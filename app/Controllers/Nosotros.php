<?php

namespace App\Controllers;

class Nosotros extends BaseController
{
    public function index()
    {
        return view('nosotros/index', [
            'title'  => 'Nosotros',
            'config' => $this->config,
        ]);
    }
}
