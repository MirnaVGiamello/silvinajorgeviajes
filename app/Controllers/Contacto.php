<?php

namespace App\Controllers;

class Contacto extends BaseController
{
    public function index()
    {
        return view('contacto/index', [
            'title'  => 'Contacto',
            'config' => $this->config,
        ]);
    }
}
