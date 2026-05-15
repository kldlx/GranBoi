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

        header('Location: ' . BASE_URL . '/login');
        exit;
    }

    public function perfil()
    {
        $this->render('profile/profile', [
            'titulo' => 'GranBoi - Perfil'
        ]);
    }

    public function index()
    {
        $usuarioModel = $this->model('Usuario');

        $this->render('usuarios/funcionarios', [
            'titulo' => 'GranBoi - Funcionários',
            'pageCss' => [
                '/public/assets/css/components/modal.css',
                '/public/assets/css/components/usuario/usuarioModal.css',
                '/public/assets/css/pages/usuarios/funcionarios.css'
            ],
            'pageJs' => [
                '/public/assets/js/validations/usuario/usuarioValidation.js',
                '/public/assets/js/modals/usuario/cadastrarUsuarioModal.js',
                '/public/assets/js/modals/usuario/editarUsuarioModal.js',
                '/public/assets/js/modals/usuario/desativarUsuarioModal.js',
                '/public/assets/js/pages/usuarios/funcionariosPage.js'
            ],
            'funcionarios' => $usuarioModel->listarTodos(),
            'papeis' => $usuarioModel->listarPapeis()
        ]);
    }

    public function salvar()
    {
        $isAjax = $this->isAjax();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => 'Requisição inválida.'
                ], 405);
            }

            $this->redirect('/funcionarios');
        }

        $dados = $this->capturarDadosFuncionario();

        $erro = $this->validarDadosFuncionario($dados, true);

        if ($erro) {
            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => $erro
                ], 422);
            }

            $_SESSION['erro'] = $erro;
            $this->redirect('/funcionarios');
        }

        try {
            $usuarioModel = $this->model('Usuario');

            $usuarioModel->salvar($dados);

            if ($isAjax) {
                $this->json([
                    'sucesso' => true,
                    'mensagem' => 'Funcionário cadastrado com sucesso.'
                ]);
            }

            $_SESSION['sucesso'] = 'Funcionário cadastrado com sucesso.';
            $this->redirect('/funcionarios');

        } catch (PDOException $e) {
            $mensagem = 'Erro ao cadastrar funcionário. Verifique os dados e tente novamente.';

            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => $mensagem
                ], 500);
            }

            $_SESSION['erro'] = $mensagem;
            $this->redirect('/funcionarios');
        }
    }

    public function atualizar()
    {
        $isAjax = $this->isAjax();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => 'Requisição inválida.'
                ], 405);
            }

            $this->redirect('/funcionarios');
        }

        $dados = $this->capturarDadosFuncionario();
        $dados['id'] = $_POST['id'] ?? '';
        $dados['status'] = $_POST['status'] ?? 'ativo';

        if (empty($dados['id'])) {
            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => 'Funcionário não informado.'
                ], 422);
            }

            $_SESSION['erro'] = 'Funcionário não informado.';
            $this->redirect('/funcionarios');
        }

        $usuarioModel = $this->model('Usuario');

        $funcionario = $usuarioModel->buscarPorId($dados['id']);

        if (!$funcionario) {
            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => 'Funcionário não encontrado.'
                ], 404);
            }

            $_SESSION['erro'] = 'Funcionário não encontrado.';
            $this->redirect('/funcionarios');
        }

        $erro = $this->validarDadosFuncionario($dados, false);

        if ($erro) {
            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => $erro
                ], 422);
            }

            $_SESSION['erro'] = $erro;
            $this->redirect('/funcionarios');
        }

        try {
            $usuarioModel->atualizar($dados);

            if ($isAjax) {
                $this->json([
                    'sucesso' => true,
                    'mensagem' => 'Funcionário atualizado com sucesso.'
                ]);
            }

            $_SESSION['sucesso'] = 'Funcionário atualizado com sucesso.';
            $this->redirect('/funcionarios');

        } catch (PDOException $e) {
            $mensagem = 'Erro ao atualizar funcionário. Verifique os dados e tente novamente.';

            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => $mensagem
                ], 500);
            }

            $_SESSION['erro'] = $mensagem;
            $this->redirect('/funcionarios');
        }
    }

    public function desativar()
    {
        $isAjax = $this->isAjax();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => 'Requisição inválida.'
                ], 405);
            }

            $this->redirect('/funcionarios');
        }

        $id = $_POST['id'] ?? '';

        if (empty($id)) {
            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => 'Funcionário não informado.'
                ], 422);
            }

            $_SESSION['erro'] = 'Funcionário não informado.';
            $this->redirect('/funcionarios');
        }

        if (!empty($_SESSION['usuario']['id']) && (int) $_SESSION['usuario']['id'] === (int) $id) {
            $mensagem = 'Você não pode desativar o próprio usuário logado.';

            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => $mensagem
                ], 422);
            }

            $_SESSION['erro'] = $mensagem;
            $this->redirect('/funcionarios');
        }

        try {
            $usuarioModel = $this->model('Usuario');

            $funcionario = $usuarioModel->buscarPorId($id);

            if (!$funcionario) {
                if ($isAjax) {
                    $this->json([
                        'sucesso' => false,
                        'mensagem' => 'Funcionário não encontrado.'
                    ], 404);
                }

                $_SESSION['erro'] = 'Funcionário não encontrado.';
                $this->redirect('/funcionarios');
            }

            $usuarioModel->desativar($id);

            if ($isAjax) {
                $this->json([
                    'sucesso' => true,
                    'mensagem' => 'Funcionário desativado com sucesso.'
                ]);
            }

            $_SESSION['sucesso'] = 'Funcionário desativado com sucesso.';
            $this->redirect('/funcionarios');

        } catch (PDOException $e) {
            $mensagem = 'Erro ao desativar funcionário. Tente novamente.';

            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => $mensagem
                ], 500);
            }

            $_SESSION['erro'] = $mensagem;
            $this->redirect('/funcionarios');
        }
    }

    public function reativar()
    {
        $isAjax = $this->isAjax();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => 'Requisição inválida.'
                ], 405);
            }

            $this->redirect('/funcionarios');
        }

        $id = $_POST['id'] ?? '';

        if (empty($id)) {
            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => 'Funcionário não informado.'
                ], 422);
            }

            $_SESSION['erro'] = 'Funcionário não informado.';
            $this->redirect('/funcionarios');
        }

        try {
            $usuarioModel = $this->model('Usuario');

            $funcionario = $usuarioModel->buscarPorId($id);

            if (!$funcionario) {
                if ($isAjax) {
                    $this->json([
                        'sucesso' => false,
                        'mensagem' => 'Funcionário não encontrado.'
                    ], 404);
                }

                $_SESSION['erro'] = 'Funcionário não encontrado.';
                $this->redirect('/funcionarios');
            }

            $usuarioModel->reativar($id);

            if ($isAjax) {
                $this->json([
                    'sucesso' => true,
                    'mensagem' => 'Funcionário reativado com sucesso.'
                ]);
            }

            $_SESSION['sucesso'] = 'Funcionário reativado com sucesso.';
            $this->redirect('/funcionarios');

        } catch (PDOException $e) {
            $mensagem = 'Erro ao reativar funcionário. Tente novamente.';

            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => $mensagem
                ], 500);
            }

            $_SESSION['erro'] = $mensagem;
            $this->redirect('/funcionarios');
        }
    }

    private function capturarDadosFuncionario()
    {
        return [
            'nome_completo' => trim($_POST['nome_completo'] ?? ''),
            'nome_social' => trim($_POST['nome_social'] ?? ''),
            'cpf' => trim($_POST['cpf'] ?? ''),
            'telefone' => trim($_POST['telefone'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'senha' => $_POST['senha'] ?? '',
            'senha_confirmacao' => $_POST['senha_confirmacao'] ?? '',
            'papel_id' => $_POST['papel_id'] ?? ''
        ];
    }

    private function validarDadosFuncionario($dados, $exigirSenha = true)
    {
        $usuarioModel = $this->model('Usuario');

        $idIgnorar = $_POST['id'] ?? null;

        if (
            empty($dados['nome_completo']) ||
            empty($dados['cpf']) ||
            empty($dados['telefone']) ||
            empty($dados['email']) ||
            empty($dados['papel_id'])
        ) {
            return 'Preencha os campos obrigatórios: nome, CPF, telefone, e-mail e função.';
        }

        if (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
            return 'Informe um e-mail válido.';
        }

        $cpfLimpo = preg_replace('/\D/', '', $dados['cpf']);

        if (strlen($cpfLimpo) !== 11) {
            return 'Informe um CPF válido com 11 dígitos.';
        }

        $telefoneLimpo = preg_replace('/\D/', '', $dados['telefone']);

        if (strlen($telefoneLimpo) < 10) {
            return 'Informe um telefone válido.';
        }

        if ($exigirSenha || !empty($dados['senha']) || !empty($dados['senha_confirmacao'])) {
            if (empty($dados['senha']) || empty($dados['senha_confirmacao'])) {
                return 'Informe e confirme a senha.';
            }

            if (strlen($dados['senha']) < 6) {
                return 'A senha deve ter pelo menos 6 caracteres.';
            }

            if ($dados['senha'] !== $dados['senha_confirmacao']) {
                return 'A confirmação de senha não confere.';
            }
        }

        if ($usuarioModel->emailExiste($dados['email'], $idIgnorar)) {
            return 'Já existe um funcionário cadastrado com este e-mail.';
        }

        if ($usuarioModel->cpfExiste($dados['cpf'], $idIgnorar)) {
            return 'Já existe um funcionário cadastrado com este CPF.';
        }

        $papeis = $usuarioModel->listarPapeis();
        $papelEncontrado = false;

        foreach ($papeis as $papel) {
            if ((int) $papel['id'] === (int) $dados['papel_id']) {
                $papelEncontrado = true;
                break;
            }
        }

        if (!$papelEncontrado) {
            return 'Selecione uma função válida para o funcionário.';
        }

        return null;
    }

    private function isAjax()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}