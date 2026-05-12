<?php

require_once ROOT_PATH . '/app/Core/Middleware.php';

$routes = [

    '/' => [
        'controller' => 'UsuarioController',
        'method' => 'login',
        'auth' => false,
        'guest' => true
    ],

    '/login' => [
        'controller' => 'UsuarioController',
        'method' => 'login',
        'auth' => false,
        'guest' => true
    ],

    '/logout' => [
        'controller' => 'UsuarioController',
        'method' => 'logout',
        'auth' => true
    ],

    '/dashboard' => [
        'controller' => 'HomeController',
        'method' => 'dashboard',
        'auth' => true,
        'roles' => ['administrador', 'gestor', 'veterinario', 'operador']
    ],

    '/animal' => [
        'controller' => 'AnimalController',
        'method' => 'listar',
        'auth' => true,
        'roles' => ['administrador', 'gestor', 'veterinario', 'operador']
    ],

    '/animal/cadastrar' => [
        'controller' => 'AnimalController',
        'method' => 'cadastrar',
        'auth' => true,
        'roles' => ['administrador', 'gestor', 'operador']
    ],

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

    '/animal/historicoPeso' => [
    'controller' => 'AnimalController',
    'method' => 'historicoPeso',
    'auth' => true,
    'roles' => ['administrador', 'gestor', 'veterinario', 'operador']
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

$basePath = parse_url(BASE_URL, PHP_URL_PATH);

$url = str_replace($basePath, '', $url);

if ($url === '') {
    $url = '/';
}

if (!isset($routes[$url])) {
    die("Rota não encontrada: {$url}");
}

$route = $routes[$url];

if (!empty($route['guest'])) {
    Middleware::guest();
}

if (!empty($route['auth'])) {
    Middleware::auth();
}

if (!empty($route['roles'])) {
    Middleware::role($route['roles']);
}

$controller = $route['controller'];
$method = $route['method'];

$controllerFile = ROOT_PATH . "/app/controllers/{$controller}.php";

if (!file_exists($controllerFile)) {
    die("Controller não encontrado: {$controller}");
}

require_once ROOT_PATH . '/app/controllers/Controller.php';
require_once $controllerFile;

$controllerInstance = new $controller();

if (!method_exists($controllerInstance, $method)) {
    die("Método não encontrado: {$method}");
}

$controllerInstance->$method();