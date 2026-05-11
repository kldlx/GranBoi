<?php

$routes = [

  '/' => ['UsuarioController', 'login'],
  '/login' => ['UsuarioController', 'login'],
  '/logout' => ['UsuarioController', 'logout'],

  '/dashboard' => ['HomeController', 'dashboard'],

  '/animal' => ['AnimalController', 'listar'],
  '/animal/cadastrar' => ['AnimalController', 'cadastrar'],
  '/animal/salvar' => ['AnimalController', 'salvar'],
  '/animal/detalhes' => ['AnimalController', 'detalhes'],
  '/animal/editar' => ['AnimalController', 'editar'],
  '/animal/excluir' => ['AnimalController', 'excluir'],

  '/vacinas' => ['VacinaController', 'listar'],
  '/vacinas/cadastrar' => ['VacinaController', 'cadastrar'],
  '/vacinas/salvar' => ['VacinaController', 'salvar'],

  '/financeiro' => ['FinanceiroController', 'index'],

  '/relatorios' => ['RelatorioController', 'index'],

  '/profile' => ['UsuarioController', 'perfil'],

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