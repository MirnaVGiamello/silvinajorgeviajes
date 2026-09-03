<?php

namespace App\Controllers;

class Contacto extends BaseController
{
    public function index()
    {
        $vista = ($this->config['tema_home'] ?? 'actual') === 'nueva' ? 'contacto/index_nueva' : 'contacto/index';

        return view($vista, [
            'title'  => 'Contacto',
            'config' => $this->config,
        ]);
    }
}
