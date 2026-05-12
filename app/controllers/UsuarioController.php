<?php

class UsuarioController extends Controller
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';

            $usuarioModel = $this->model('Usuario');

            $resultado = $usuarioModel->logarUsuario($email, $senha);

            if ($resultado['sucesso']) {

                $_SESSION['usuario'] = $resultado['usuario'];

                $_SESSION['user'] = [
                    'name' => $resultado['usuario']['nome'],
                    'email' => $resultado['usuario']['email'],
                    'papel' => $resultado['usuario']['papel']
                ];

                $this->redirect('/dashboard');
            }

            $_SESSION['erro'] = $resultado['mensagem'];

            $this->redirect('/login');
        }

        $this->renderAuth('auth/login');
    }

    public function logout()
    {
        session_destroy();

        $this->redirect('/login');
    }

    public function perfil()
    {
        $this->render('profile/profile');
    }
}