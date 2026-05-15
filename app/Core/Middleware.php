<?php

class Middleware
{
    public static function auth()
    {
        if (!isset($_SESSION['usuario'])) {
            if (self::isAjax()) {
                self::json([
                    'sucesso' => false,
                    'mensagem' => 'Sessão expirada. Faça login novamente.'
                ], 401);
            }

            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }

    public static function guest()
    {
        if (isset($_SESSION['usuario'])) {
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }
    }

    public static function role($rolesPermitidos)
    {
        self::auth();

        $papelUsuario = self::normalizarPapel($_SESSION['usuario']['papel'] ?? '');

        $rolesNormalizados = array_map(function ($role) {
            return self::normalizarPapel($role);
        }, $rolesPermitidos);

        if (!in_array($papelUsuario, $rolesNormalizados)) {
            if (self::isAjax()) {
                self::json([
                    'sucesso' => false,
                    'mensagem' => 'Acesso negado. Você não tem permissão para executar esta ação.'
                ], 403);
            }

            die('Acesso negado. Você não tem permissão para acessar esta página.');
        }
    }

    private static function normalizarPapel($papel)
    {
        $papel = mb_strtolower(trim($papel), 'UTF-8');

        $mapa = [
            'administrador' => 'administrador',
            'gestor' => 'gestor',
            'veterinário' => 'veterinario',
            'veterinario' => 'veterinario',
            'operador' => 'operador'
        ];

        return $mapa[$papel] ?? $papel;
    }

    private static function isAjax()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    private static function json($dados, $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');

        echo json_encode($dados);
        exit;
    }
}