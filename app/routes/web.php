<?php

$routes = [

  '/' => ['UsuarioController', 'login'],
  '/login' => ['UsuarioController', 'login'],
  '/logout' => ['UsuarioController', 'logout'],

  '/dashboard' => ['HomeController', 'dashboard'],
  
'/animal' => ['AnimalController', 'listar'],
'/animal/listar' => ['AnimalController', 'listar'],
'/animal/cadastrar' => ['AnimalController', 'cadastrar'],
'/animal/salvar' => ['AnimalController', 'salvar'],
'/animal/detalhes' => ['AnimalController', 'detalhes'],
'/animal/editar' => ['AnimalController', 'editar'],
'/animal/atualizar' => ['AnimalController', 'atualizar'],
'/animal/excluir' => ['AnimalController', 'excluir'],
'/animal/adicionarPeso' => ['AnimalController', 'adicionarPeso'],
'/animal/historicoPeso' => ['AnimalController', 'historicoPeso'],


  '/vacinas' => ['VacinaController', 'listar'],
  '/vacinas/cadastrar' => ['VacinaController', 'cadastrar'],
  '/vacinas/salvar' => ['VacinaController', 'salvar'],

  '/financeiro' => ['FinanceiroController', 'index'],

  '/relatorios' => ['RelatorioController', 'index'],

    '/animal/salvar' => [
        'controller' => 'AnimalController',
        'method' => 'salvar',
        'auth' => true,
        'roles' => ['administrador', 'gestor', 'operador']
    ],

    '/animal/detalhes' => [
        'controller' => 'AnimalController',
        'method' => 'detalhes',
        'auth' => true,
        'roles' => ['administrador', 'gestor', 'veterinario', 'operador']
    ],

    '/animal/editar' => [
        'controller' => 'AnimalController',
        'method' => 'editar',
        'auth' => true,
        'roles' => ['administrador', 'gestor', 'operador']
    ],

    '/animal/atualizar' => [
    'controller' => 'AnimalController',
    'method' => 'atualizar',
    'auth' => true,
    'roles' => ['administrador', 'gestor', 'operador']
    ],

    '/animal/excluir' => [
    'controller' => 'AnimalController',
    'method' => 'excluir',
    'auth' => true,
    'roles' => ['administrador', 'gestor']
    ],

    '/peso' => [
    'controller' => 'PesoController',
    'method' => 'index',
    'auth' => true,
    'roles' => ['administrador', 'gestor', 'veterinario', 'operador']
],

    '/peso/salvar' => [
    'controller' => 'PesoController',
    'method' => 'salvar',
    'auth' => true,
    'roles' => ['administrador', 'gestor', 'operador']
],

'/peso/historico' => [
    'controller' => 'PesoController',
    'method' => 'historico',
    'auth' => true,
    'roles' => ['administrador', 'gestor', 'veterinario', 'operador']
],

    '/vacinas' => [
        'controller' => 'VacinaController',
        'method' => 'listar',
        'auth' => true,
        'roles' => ['administrador', 'gestor', 'veterinario']
    ],

    '/vacinas/cadastrar' => [
        'controller' => 'VacinaController',
        'method' => 'cadastrar',
        'auth' => true,
        'roles' => ['administrador', 'veterinario']
    ],

    '/vacinas/salvar' => [
        'controller' => 'VacinaController',
        'method' => 'salvar',
        'auth' => true,
        'roles' => ['administrador', 'veterinario']
    ],

    '/financeiro' => [
        'controller' => 'FinanceiroController',
        'method' => 'index',
        'auth' => true,
        'roles' => ['administrador', 'gestor']
    ],

    '/relatorios' => [
        'controller' => 'RelatorioController',
        'method' => 'index',
        'auth' => true,
        'roles' => ['administrador', 'gestor']
    ],

    '/profile' => [
        'controller' => 'UsuarioController',
        'method' => 'perfil',
        'auth' => true,
        'roles' => ['administrador', 'gestor', 'veterinario', 'operador']
    ],

];

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


$basePath = '/granboi';

$url = str_replace($basePath, '', $url);

if ($url === '') {
    $url = '/';
}


if (!isset($routes[$url])) {
    die("Rota não encontrada: {$url}");
}


[$controller, $method] = $routes[$url];


$controllerFile = __DIR__ . "/../controllers/{$controller}.php";

if (!file_exists($controllerFile)) {
    die("Controller não encontrado: {$controller}");
}

require_once __DIR__ . '/../controllers/Controller.php';
require_once $controllerFile;


$controllerInstance = new $controller();


if (!method_exists($controllerInstance, $method)) {
    die("Método não encontrado: {$method}");
}

$controllerInstance->$method();