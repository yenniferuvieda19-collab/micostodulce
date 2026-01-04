<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Página de inicio - Dashboard principal
$routes->get('/', 'Home::index');

/*
 * --------------------------------------------------------------------
 * Módulo de Autenticación (Auth).
 * --------------------------------------------------------------------
 * Aquí manejamos el ingreso de los reposteros al sistema.
 */
$routes->get('login', 'Auth::login');             // Pantalla de entrada
$routes->post('auth/ingresar', 'Auth::ingresar'); // Procesa el formulario de login
$routes->get('registro', 'Auth::registro');       // Pantalla para nuevos usuarios
$routes->post('auth/registrar', 'Auth::registrar'); 
$routes->get('salir', 'Auth::salir');             // Cerrar sesión
$routes->get('recuperar', 'Auth::recuperar');     // Olvido de  clave del usuario
$routes->post('auth/enviar-recuperacion', 'Auth::enviarRecuperacion');
$routes->get('auth/enviar-recuperacion', 'Auth::recuperar');
/*
 * --------------------------------------------------------------------
 * Módulo de Ingredientes (Insumos)
 * --------------------------------------------------------------------
 * Usamos 'resource' para que CI4 cree automáticamente las rutas de:
 * index, show, create, update y delete. 
 */
$routes->group('ingredientes', function($routes) {
    $routes->get('/', 'Ingredientes::index');         // Listado de harina, azúcar, etc.
    $routes->get('crear', 'Ingredientes::crear');     // Formulario de nuevo insumo
    $routes->post('guardar', 'Ingredientes::guardar'); // Guardar en DB
    $routes->get('editar/(:num)', 'Ingredientes::editar/$1'); // Cargar datos para editar
    $routes->post('actualizar/(:num)', 'Ingredientes::actualizar/$1');
    $routes->get('borrar/(:num)', 'Ingredientes::borrar/$1');
});

/*
 * --------------------------------------------------------------------
 * Módulo de Recetas (El corazón del negocio)
 * --------------------------------------------------------------------
 */
// Grupo de recetas: Todo lo que empiece con /recetas irá aquí
$routes->group('recetas', function($routes) {
    
    $routes->get('/', 'Recetas::index'); 
    
    $routes->get('crear', 'Recetas::crear'); 

    // Estas rutas las usaremos después para guardar datos y borrar
    $routes->post('guardar', 'Recetas::guardar');
    $routes->get('borrar/(:num)', 'Recetas::borrar/$1');

});
