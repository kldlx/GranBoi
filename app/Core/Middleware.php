<?php

class Middleware
{
    public static function auth()
    {
        if (!isset($_SESSION['usuario'])) {
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

        $papelUsuario = $_SESSION['usuario']['papel'] ?? '';

        if (!in_array($papelUsuario, $rolesPermitidos)) {
            die('Acesso negado. Você não tem permissão para acessar esta página.');
        }
    }
}