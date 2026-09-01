<?php

namespace App\Controllers;

use App\Models\ConfiguracionModel;
use App\Models\PromocionModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    protected array $config = [];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->config = (new ConfiguracionModel())->actual();
        (new PromocionModel())->desactivarVencidas();
    }
}
