<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Públicas
$routes->get('/', 'Home::index');
$routes->get('mapaDeslogado', 'MapaDeslogado::index');

// Acesso: login, cadastro e saída (POST protegido por CSRF)
$routes->get('entrar', 'Login::index');
$routes->post('entrar', 'Login::autenticar', ['filter' => 'csrf']);
$routes->post('cadastrar', 'Login::cadastrar', ['filter' => 'csrf']);
$routes->post('sair', 'Login::sair', ['filter' => 'csrf']);

// Área do ponto de coleta (gerador)
$routes->get('inicioPontoColeta', 'InicioPontoColeta::index', ['filter' => 'auth:ponto_coleta']);
$routes->get('Agendar', 'AgendarColeta::index', ['filter' => 'auth:ponto_coleta']);
$routes->post('Agendar', 'AgendarColeta::salvar', ['filter' => ['csrf', 'auth:ponto_coleta']]);
$routes->get('Agendar/editar/(:num)', 'AgendarColeta::editar/$1', ['filter' => 'auth:ponto_coleta']);
$routes->post('Agendar/editar/(:num)', 'AgendarColeta::atualizar/$1', ['filter' => ['csrf', 'auth:ponto_coleta']]);
$routes->post('pontoColeta/aceitar/(:num)', 'InicioPontoColeta::aceitar/$1', ['filter' => ['csrf', 'auth:ponto_coleta']]);
$routes->post('pontoColeta/recusar/(:num)', 'InicioPontoColeta::recusar/$1', ['filter' => ['csrf', 'auth:ponto_coleta']]);
$routes->post('pontoColeta/excluir/(:num)', 'InicioPontoColeta::excluir/$1', ['filter' => ['csrf', 'auth:ponto_coleta']]);

// Área do coletor
$routes->get('inicioColetor', 'InicioColetor::index', ['filter' => 'auth:coletor_licenciado']);
$routes->get('coletorPontosDisponiveis', 'ColetorPontosDisponiveis::index', ['filter' => 'auth:coletor_licenciado']);
$routes->post('coletor/solicitar/(:num)', 'ColetorPontosDisponiveis::solicitar/$1', ['filter' => ['csrf', 'auth:coletor_licenciado']]);
$routes->post('coletor/finalizar/(:num)', 'InicioColetor::finalizar/$1', ['filter' => ['csrf', 'auth:coletor_licenciado']]);
$routes->post('coletor/liberar/(:num)', 'InicioColetor::liberar/$1', ['filter' => ['csrf', 'auth:coletor_licenciado']]);

// Qualquer usuário logado
$routes->get('homeLogado', 'HomeLogado::index', ['filter' => 'auth']);
$routes->get('mapa', 'Mapa::index', ['filter' => 'auth']);
