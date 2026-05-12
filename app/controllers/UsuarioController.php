<?php

class UsuarioController extends Controller
{
    public function login()
    {
        if (isset($_SESSION['user']) && $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';

            $usuarioModel = $this->model('Usuario');
            $resultado = $usuarioModel->logarUsuario($email, $senha);

            if (is_array($resultado)) {
                $papeis = [
                    1 => 'administrador',
                    2 => 'gestor',
                    3 => 'veterinario',
                    4 => 'operador',
                ];
                $papelId = (int) ($resultado['papel']['papel_id'] ?? 0);

                $_SESSION['user'] = [
                    'id' => $resultado['usuario']['id'],
                    'name' => $resultado['usuario']['nome'],
                    'email' => $resultado['usuario']['email'],
                    'papel' => $papeis[$papelId] ?? ''
                ];

                header('Location: ' . BASE_URL . '/dashboard');
                exit;
            }

            $_SESSION['erro'] = 'E-mail ou senha invalidos';

            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $this->render('auth/login');
    }

    public function logout()
    {
        session_destroy();

        header('Location: ' . BASE_URL . '/login');
        exit;
    }

    public function perfil()
    {
        $this->requireLogin();

        $this->render('profile/profile');
    }
}
