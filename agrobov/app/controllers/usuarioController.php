<?php

require_once "Controller.php";

class UsuarioController extends Controller
{
    public function cadastro()
    {
        return $this->render("usuarios/Cadastro");
    }

    public function cadastrar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        if ($_POST['senha'] !== $_POST['senhac']) {
            $_SESSION['erro'] = "As senhas não coincidem.";
            header("Location: /usuario/cadastro");
            exit;
        }

        $_POST['cpf'] = $this->limparNumero($_POST['cpf']);
        $_POST['telefone'] = $this->limparNumero($_POST['telefone']);

        $pessoa = $this->model('Pessoa');
        $resultado = $pessoa->cadastrar($_POST);

        if ($resultado === true) {
            $_SESSION['sucesso'] = "Usuário cadastrado!";
            header("Location: /login");
        } elseif ($resultado === "duplicado") {
            $_SESSION['erro'] = "E-mail ou CPF já cadastrado.";
            header("Location: /usuario/cadastro");
        } else {
            $_SESSION['erro'] = "Erro ao cadastrar.";
            header("Location: /usuario/cadastro");
        }

        exit;
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return $this->render('auth/login');
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $usuario = $this->model('Usuario')->findByEmail($email);

        if ($usuario && password_verify($password, $usuario['password'])) {

            $_SESSION['user'] = $usuario;

            header("Location: /dashboard");
            exit;
        }

        $_SESSION['erro'] = "Credenciais inválidas";
        header("Location: /login");
        exit;
    }

    public function logout()
    {
        session_destroy();
        header("Location: /login");
        exit;
    }

    private function limparNumero($valor)
    {
        return preg_replace('/\D/', '', $valor);
    }
}