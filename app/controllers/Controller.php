<?php

class Controller
{
   protected function render($view, $dados = [])
{
    $viewPath = __DIR__ . "/../views/{$view}.php";

    if (!file_exists($viewPath)) {
        die("View não encontrada: {$view}");
    }

    extract($dados);

    require_once __DIR__ . "/../layout/cabecalho.php";
    require_once $viewPath;
    require_once __DIR__ . "/../layout/rodape.php";
}

    protected function view($view, $dados = [])
    {
        return $this->render($view, $dados);
    }

    protected function requireLogin()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }

    protected function requireRole($roles)
    {
        $this->requireLogin();

        $roles = (array) $roles;
        $papel = $_SESSION['user']['papel'] ?? '';

        if (!in_array($papel, $roles, true)) {
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }
    }

    protected function model($model)
    {
        $modelPath = __DIR__ . "/../models/{$model}.php";

        if (!file_exists($modelPath)) {
            die("Model não encontrado: {$model}");
        }

        require_once $modelPath;

        return new $model();
    }
}
