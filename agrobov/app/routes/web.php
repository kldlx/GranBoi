<?php

$routes = [
    '/' => ['HomeController', 'index'],
    '/login' => ['UsuarioController', 'login'],
    '/dashboard' => ['HomeController', 'dashboard'],

    // NOVAS ROTAS (já preparadas pra teu sistema)
    '/animal/listar' => ['AnimalController', 'listar'],
    '/animal/cadastrar' => ['AnimalController', 'cadastrar'],

    '/financeiro' => ['FinanceiroController', 'index'],
    '/financeiro/receitas' => ['FinanceiroController', 'receitas'],
    '/financeiro/despesas' => ['FinanceiroController', 'despesas'],

    '/vacinas' => ['VacinaController', 'index'],

    '/animal/adicionarPeso' => ['AnimalController', 'adicionarPeso'],
    '/animal/historicoPeso' => ['AnimalController', 'historicoPeso'],
];

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($uri, '/');

if ($uri === '') {
    $uri = '/';
}

if (!isset($routes[$uri])) {
    http_response_code(404);
    echo "404 - Página não encontrada";
    exit;
}

[$controllerName, $method] = $routes[$uri];

$controllerPath = "../app/controllers/{$controllerName}.php";

if (!file_exists($controllerPath)) {
    die("Controller não encontrado: {$controllerName}");
}

require_once $controllerPath;

$controller = new $controllerName();

if (!method_exists($controller, $method)) {
    die("Método {$method} não existe em {$controllerName}");
}

$controller->$method();