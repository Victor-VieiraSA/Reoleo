<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('entrar', 'Login::index');
$routes->get('inicioPontoColeta', 'InicioPontoColeta::index');
$routes->get('Agendar', 'AgendarColeta::index');
$routes->get('inicioColetor', 'inicioColetor::index');
$routes->get('coletorPontosDisponiveis', 'coletorPontosDisponiveis::index');
$routes->get('homeLogado', 'homeLogado::index');
$routes->get('mapa', 'mapa::index');
$routes->get('mapaDeslogado', 'mapaDeslogado::index');
