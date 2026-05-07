<?php

$routes = [
    '/' => ['HomeController', 'index'],
    '/login' => ['UsuarioController', 'login'],
    '/dashboard' => ['HomeController', 'dashboard'],
];

// Pega URL limpa
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove barra final se existir
$uri = rtrim($uri, '/');

if ($uri === '') {
    $uri = '/';
}

if (isset($routes[$uri])) {

    $controllerName = $routes[$uri][0];
    $method = $routes[$uri][1];

    $controllerPath = "../app/controllers/{$controllerName}.php";

    if (!file_exists($controllerPath)) {
        die("Controller não encontrado: $controllerName");
    }

    require_once $controllerPath;

    $controller = new $controllerName();
    $controller->$method();

} else {
    http_response_code(404);
    echo "404 - Página não encontrada";
}