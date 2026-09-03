<?php

namespace App\Controllers;

class Nosotros extends BaseController
{
    public function index()
    {
        $vista = ($this->config['tema_home'] ?? 'actual') === 'nueva' ? 'nosotros/index_nueva' : 'nosotros/index';

        return view($vista, [
            'title'  => 'Sobre mí',
            'config' => $this->config,
        ]);
    }
}
