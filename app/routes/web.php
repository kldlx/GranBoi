<?php

$routes = [

  // AUTH
  '/' => ['UsuarioController', 'login'],
  '/login' => ['UsuarioController', 'login'],
  '/logout' => ['UsuarioController', 'logout'],

  // DASHBOARD
  '/dashboard' => ['HomeController', 'dashboard'],

  // ANIMAL
  '/animal' => ['AnimalController', 'listar'],
  '/animal/cadastrar' => ['AnimalController', 'cadastrar'],
  '/animal/salvar' => ['AnimalController', 'salvar'],
  '/animal/detalhes' => ['AnimalController', 'detalhes'],
  '/animal/editar' => ['AnimalController', 'editar'],
  '/animal/excluir' => ['AnimalController', 'excluir'],

  // VACINAS
  '/vacinas' => ['VacinaController', 'listar'],
  '/vacinas/cadastrar' => ['VacinaController', 'cadastrar'],
  '/vacinas/salvar' => ['VacinaController', 'salvar'],

  // FINANCEIRO
  '/financeiro' => ['FinanceiroController', 'index'],

  // RELATÓRIOS
  '/relatorios' => ['RelatorioController', 'index'],

  // PERFIL
  '/profile' => ['UsuarioController', 'perfil'],

];

/*
|--------------------------------------------------------------------------
| ROUTER
|--------------------------------------------------------------------------
*/

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


$basePath = '/granboi';

$url = str_replace($basePath, '', $url);

if ($url === '') {
    $url = '/';
}

/*
|--------------------------------------------------------------------------
| VERIFICA ROTA
|--------------------------------------------------------------------------
*/

if (!isset($routes[$url])) {
    die("Rota não encontrada: {$url}");
}

/*
|--------------------------------------------------------------------------
| CONTROLLER E MÉTODO
|--------------------------------------------------------------------------
*/

[$controller, $method] = $routes[$url];

/*
|--------------------------------------------------------------------------
| ARQUIVO DO CONTROLLER
|--------------------------------------------------------------------------
*/

$controllerFile = __DIR__ . "/../controllers/{$controller}.php";

if (!file_exists($controllerFile)) {
    die("Controller não encontrado: {$controller}");
}

require_once __DIR__ . '/../controllers/Controller.php';
require_once $controllerFile;

/*
|--------------------------------------------------------------------------
| INSTANCIA CONTROLLER
|--------------------------------------------------------------------------
*/

$controllerInstance = new $controller();

/*
|--------------------------------------------------------------------------
| EXECUTA MÉTODO
|--------------------------------------------------------------------------
*/

if (!method_exists($controllerInstance, $method)) {
    die("Método não encontrado: {$method}");
}

$controllerInstance->$method();