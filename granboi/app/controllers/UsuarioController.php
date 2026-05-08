<?php

class UsuarioController extends Controller
{
    public function login()
    {
        // LOGIN
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';

            // LOGIN FAKE
            if (
                $email === 'admin@granboi.com'
                &&
                $senha === '123456'
            ) {

                $_SESSION['user'] = [
                    'name' => 'Administrador',
                    'email' => $email
                ];

                header('Location: ' . BASE_URL . '/dashboard');
                exit;
            }

            $_SESSION['erro'] = 'E-mail ou senha inválidos';

            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        // VIEW LOGIN
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
        $this->render('profile/profile');
    }
}