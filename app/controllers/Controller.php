<?php

class Controller
{
    protected function render($view, $dados = [])
    {
        $viewPath = ROOT_PATH . "/app/views/{$view}.php";

        if (!file_exists($viewPath)) {
            die("View não encontrada: {$view}");
        }

        extract($dados);

        require_once ROOT_PATH . "/app/layout/cabecalho.php";
        require_once $viewPath;
        require_once ROOT_PATH . "/app/layout/rodape.php";
    }

    protected function renderAuth($view, $dados = [])
    {
        $viewPath = ROOT_PATH . "/app/views/{$view}.php";

        if (!file_exists($viewPath)) {
            die("View de autenticação não encontrada: {$view}");
        }

        extract($dados);

        require_once $viewPath;
    }

    protected function renderPartial($view, $dados = [])
    {
        $viewPath = ROOT_PATH . "/app/views/{$view}.php";

        if (!file_exists($viewPath)) {
            die("Partial não encontrada: {$view}");
        }

        extract($dados);

        require_once $viewPath;
    }

    protected function json($dados, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');

        echo json_encode($dados, JSON_UNESCAPED_UNICODE);
        exit;
    }

    protected function redirect($rota)
    {
        header('Location: ' . BASE_URL . $rota);
        exit;
    }

    protected function model($model)
    {
        $modelPath = ROOT_PATH . "/app/models/{$model}.php";

        if (!file_exists($modelPath)) {
            die("Model não encontrado: {$model}");
        }

        require_once $modelPath;

        return new $model();
    }
}