<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

// Sitio publico
$routes->get('/', 'Home::index');
$routes->get('promociones', 'Promociones::index');
$routes->get('promociones/(:num)', 'Promociones::ver/$1');
$routes->get('nosotros', 'Nosotros::index');
$routes->get('contacto', 'Contacto::index');

// Autenticación
$routes->get('login',  'Auth::index');
$routes->post('login', 'Auth::login');
$routes->get('logout', 'Auth::logout');

// Panel: accesible para ambos perfiles (admin y operador) - gestion de promociones
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Admin\Dashboard::index');

    $routes->get( 'promociones',                 'Admin\Promociones::index');
    $routes->get( 'promociones/nueva',           'Admin\Promociones::nueva');
    $routes->post('promociones/guardar',         'Admin\Promociones::guardar');
    $routes->get( 'promociones/editar/(:num)',   'Admin\Promociones::editar/$1');
    $routes->post('promociones/actualizar/(:num)', 'Admin\Promociones::actualizar/$1');
    $routes->post('promociones/eliminar/(:num)',   'Admin\Promociones::eliminar/$1');
    $routes->post('promociones/imagen/eliminar/(:num)', 'Admin\Promociones::eliminarImagen/$1');
});

// Administración: solo perfil admin
$routes->group('admin', ['filter' => 'admin'], function ($routes) {
    $routes->get( 'usuarios',                   'Admin\Usuarios::index');
    $routes->get( 'usuarios/nuevo',             'Admin\Usuarios::nuevo');
    $routes->post('usuarios/guardar',           'Admin\Usuarios::guardar');
    $routes->get( 'usuarios/editar/(:num)',     'Admin\Usuarios::editar/$1');
    $routes->post('usuarios/actualizar/(:num)', 'Admin\Usuarios::actualizar/$1');
    $routes->post('usuarios/eliminar/(:num)',   'Admin\Usuarios::eliminar/$1');

    $routes->get( 'configuracion',   'Admin\Configuracion::index');
    $routes->post('configuracion',   'Admin\Configuracion::guardar');

    $routes->get( 'categorias',                 'Admin\Categorias::index');
    $routes->post('categorias/guardar',         'Admin\Categorias::guardar');
    $routes->post('categorias/eliminar/(:num)', 'Admin\Categorias::eliminar/$1');
});
