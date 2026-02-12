<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

/*
 * --------------------------------------------------------------------
 * PÁGINA DE INICIO Y REDIRECCIÓN
 * --------------------------------------------------------------------
 */
$routes->get('/', 'Home::index');
$routes->get('home', 'Home::index'); 

/*
 * --------------------------------------------------------------------
 * MÓDULO DE AUTENTICACIÓN
 * --------------------------------------------------------------------
 */
$routes->get('login', 'Auth::login');
$routes->post('auth/ingresar', 'Auth::ingresar');
$routes->get('registro', 'Auth::registro');
$routes->post('auth/registrar', 'Auth::registrar');
$routes->get('salir', 'Auth::salir');
$routes->get('panel', 'Auth::panel'); 

// Recuperación de contraseña
$routes->get('recuperar', 'Auth::recuperar');
$routes->post('auth/enviar-recuperacion', 'Auth::enviarRecuperacion');
$routes->get('resetPassword/(:any)', 'Auth::verificacionGmail/$1'); 
$routes->post('auth/update_password', 'Auth::ProcesarContrasena'); 

/*
 * --------------------------------------------------------------------
 * MÓDULO DE INGREDIENTES (INSUMOS)
 * --------------------------------------------------------------------
 */
$routes->group('ingredientes', function ($routes) {
    $routes->get('/', 'Ingredientes::index');
    $routes->get('crear', 'Ingredientes::crear');
    $routes->post('guardar', 'Ingredientes::guardar');
    $routes->get('editar/(:num)', 'Ingredientes::editar/$1');
    $routes->post('actualizar/(:num)', 'Ingredientes::actualizar/$1');
    $routes->get('borrar/(:num)', 'Ingredientes::borrar/$1');
});

/*
 * --------------------------------------------------------------------
 * MÓDULO DE RECETAS
 * --------------------------------------------------------------------
 */
$routes->group('recetas', function ($routes) {
    $routes->get('/', 'Recetas::index');
    $routes->get('crear', 'Recetas::crear');
    $routes->post('guardar', 'Recetas::guardar');
    $routes->get('ver/(:num)', 'Recetas::ver/$1');
    $routes->get('editar/(:num)', 'Recetas::editar/$1');
    $routes->post('actualizar/(:num)', 'Recetas::actualizar/$1');
    $routes->get('borrar/(:num)', 'Recetas::borrar/$1');
});

/*
 * --------------------------------------------------------------------
 * MÓDULO DE GASTOS INDIRECTOS
 * --------------------------------------------------------------------
 */
$routes->group('gastos', function ($routes) {
    $routes->get('/', 'Gastos::index');
    $routes->get('crear', 'Gastos::crear');
    $routes->post('guardar', 'Gastos::guardar');
    $routes->get('editar/(:num)', 'Gastos::editar/$1');
    $routes->post('actualizar/(:num)', 'Gastos::actualizar/$1');
    $routes->get('borrar/(:num)', 'Gastos::borrar/$1');
});

/*
 * --------------------------------------------------------------------
 * MÓDULO DE INVENTARIO Y PRODUCCIÓN (ACTUALIZADO)
 * --------------------------------------------------------------------
 */
$routes->group('inventario', function ($routes) {
    $routes->get('/', 'Inventario::index');
    $routes->get('crear', 'Inventario::crear');
    $routes->post('guardar', 'Inventario::guardar');
    $routes->get('ver/(:num)', 'Inventario::ver/$1');      // Ruta para el icono del OJO
    $routes->get('eliminar/(:num)', 'Inventario::eliminar/$1'); // Ruta para el icono de la PAPELERA
});

/*
 * --------------------------------------------------------------------
 * MÓDULO DE VENTAS
 * --------------------------------------------------------------------
 */
$routes->group('ventas', function ($routes) {
    $routes->get('/', 'Ventas::index');
    $routes->get('crear', 'Ventas::crear');
    $routes->post('guardar', 'Ventas::guardar');
    $routes->get('detalle/(:num)', 'Ventas::detalle/$1');
    $routes->get('eliminar/(:num)', 'Ventas::eliminar/$1');
});