<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- PÁGINA DE INICIO ---
$routes->get('/', 'Home::index');

/*
 * --------------------------------------------------------------------
 * Módulo de Autenticación (Login y Registro)
 * --------------------------------------------------------------------
 */
$routes->get('login', 'Auth::login');             // Pantalla de entrada
$routes->post('auth/ingresar', 'Auth::ingresar'); // Procesa el formulario
$routes->get('registro', 'Auth::registro');       // Pantalla registro
$routes->post('auth/registrar', 'Auth::registrar'); 
$routes->get('salir', 'Auth::salir');             // Cerrar sesión
$routes->get('panel', 'Auth::panel'); //Carga el panel de bienvenida al portal web.

// Recuperación de contraseña
$routes->get('recuperar', 'Auth::recuperar');     
$routes->post('auth/enviar-recuperacion', 'Auth::enviarRecuperacion');
$routes->get('resetPassword/(:any)', 'Auth::verificacionGmail/$1'); 
$routes->post('auth/update_password', 'Auth::RecuperarContrasena'); 

/*
 * --------------------------------------------------------------------
 * Módulo de Ingredientes (Insumos)
 * --------------------------------------------------------------------
 */
$routes->group('ingredientes', function($routes) {
    $routes->get('/', 'Ingredientes::index');          // Ver lista
    $routes->get('crear', 'Ingredientes::crear');      // Formulario crear
    $routes->post('guardar', 'Ingredientes::guardar'); // Guardar nuevo
    
    // Editar y Borrar Insumos
    $routes->get('editar/(:num)', 'Ingredientes::editar/$1'); 
    $routes->post('actualizar/(:num)', 'Ingredientes::actualizar/$1');
    $routes->get('borrar/(:num)', 'Ingredientes::borrar/$1');
});

/*
 * --------------------------------------------------------------------
 * Módulo de Recetas (El corazón del negocio)
 * --------------------------------------------------------------------
 */
$routes->group('recetas', function($routes) {
    $routes->get('/', 'Recetas::index');           // Ver tarjetas
    $routes->get('crear', 'Recetas::crear');       // Formulario crear
    $routes->post('guardar', 'Recetas::guardar');  // Guardar nueva

    $routes->get('ver/(:num)', 'Recetas::ver/$1'); //ruta para Ver la receta en solo vista
    
    // Editar y Borrar Recetas (Ahora están en su lugar correcto)
    $routes->get('editar/(:num)', 'Recetas::editar/$1'); 
    $routes->post('actualizar/(:num)', 'Recetas::actualizar/$1');
    $routes->get('borrar/(:num)', 'Recetas::borrar/$1');
});