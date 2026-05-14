<?php

class VacinaController extends Controller
{
    public function listar()
    {
        $vacinacaoModel = $this->model('Vacinacao');
        $animalModel = $this->model('Animal');

        $this->render('vacinas/vacinas', [
            'titulo' => 'GranBoi - Vacinação',
            'pageCss' => [
                '/public/assets/css/components/modal.css',
                '/public/assets/css/components/vacinacao/vacinacaoModal.css',
                '/public/assets/css/pages/vacinas/vacinas.css'
            ],
            'pageJs' => [
                '/public/assets/js/validations/vacinacao/vacinacaoValidation.js',
                '/public/assets/js/modals/vacinacao/cadastrarVacinacaoModal.js',
                '/public/assets/js/pages/vacinas/vacinasPage.js'
            ],
            'vacinacoes' => $vacinacaoModel->listarTodas(),
            'animais' => $animalModel->listarTodos()
        ]);
    }

    public function cadastrar()
    {
        $this->redirect('/vacinas');
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

            $this->redirect('/vacinas');
        }

        $dados = $this->capturarDadosFormulario();

        $erro = $this->validarDadosVacinacao($dados);

        if ($erro) {
            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => $erro
                ], 422);
            }

            $_SESSION['erro'] = $erro;
            $this->redirect('/vacinas');
        }

        try {
            $vacinacaoModel = $this->model('Vacinacao');

            $vacinacaoModel->salvar($dados);

            if ($isAjax) {
                $this->json([
                    'sucesso' => true,
                    'mensagem' => 'Vacinação registrada com sucesso.'
                ]);
            }

            $_SESSION['sucesso'] = 'Vacinação registrada com sucesso.';
            $this->redirect('/vacinas');

        } catch (PDOException $e) {
            $mensagem = 'Erro ao registrar vacinação. Verifique os dados e tente novamente.';

            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => $mensagem
                ], 500);
            }

            $_SESSION['erro'] = $mensagem;
            $this->redirect('/vacinas');
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

            $this->redirect('/vacinas');
        }

        $dados = $this->capturarDadosFormulario();
        $dados['id'] = $_POST['id'] ?? '';

        if (empty($dados['id'])) {
            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => 'Vacinação não informada.'
                ], 422);
            }

            $_SESSION['erro'] = 'Vacinação não informada.';
            $this->redirect('/vacinas');
        }

        $vacinacaoModel = $this->model('Vacinacao');

        $vacinacao = $vacinacaoModel->buscarPorId($dados['id']);

        if (!$vacinacao) {
            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => 'Vacinação não encontrada.'
                ], 404);
            }

            $_SESSION['erro'] = 'Vacinação não encontrada.';
            $this->redirect('/vacinas');
        }

        $erro = $this->validarDadosVacinacao($dados);

        if ($erro) {
            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => $erro
                ], 422);
            }

            $_SESSION['erro'] = $erro;
            $this->redirect('/vacinas');
        }

        try {
            $vacinacaoModel->atualizar($dados);

            if ($isAjax) {
                $this->json([
                    'sucesso' => true,
                    'mensagem' => 'Vacinação atualizada com sucesso.'
                ]);
            }

            $_SESSION['sucesso'] = 'Vacinação atualizada com sucesso.';
            $this->redirect('/vacinas');

        } catch (PDOException $e) {
            $mensagem = 'Erro ao atualizar vacinação. Verifique os dados e tente novamente.';

            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => $mensagem
                ], 500);
            }

            $_SESSION['erro'] = $mensagem;
            $this->redirect('/vacinas');
        }
    }

    public function excluir()
    {
        $isAjax = $this->isAjax();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => 'Requisição inválida.'
                ], 405);
            }

            $this->redirect('/vacinas');
        }

        $id = $_POST['id'] ?? '';

        if (empty($id)) {
            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => 'Vacinação não informada.'
                ], 422);
            }

            $_SESSION['erro'] = 'Vacinação não informada.';
            $this->redirect('/vacinas');
        }

        $vacinacaoModel = $this->model('Vacinacao');

        $vacinacao = $vacinacaoModel->buscarPorId($id);

        if (!$vacinacao) {
            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => 'Vacinação não encontrada.'
                ], 404);
            }

            $_SESSION['erro'] = 'Vacinação não encontrada.';
            $this->redirect('/vacinas');
        }

        try {
            $vacinacaoModel->excluir($id);

            if ($isAjax) {
                $this->json([
                    'sucesso' => true,
                    'mensagem' => 'Vacinação excluída com sucesso.'
                ]);
            }

            $_SESSION['sucesso'] = 'Vacinação excluída com sucesso.';
            $this->redirect('/vacinas');

        } catch (PDOException $e) {
            $mensagem = 'Erro ao excluir vacinação. Tente novamente.';

            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => $mensagem
                ], 500);
            }

            $_SESSION['erro'] = $mensagem;
            $this->redirect('/vacinas');
        }
    }

    private function capturarDadosFormulario()
    {
        return [
            'animal_id' => $_POST['animal_id'] ?? '',
            'vacina' => trim($_POST['vacina'] ?? ''),
            'data_aplicacao' => $_POST['data_aplicacao'] ?? '',
            'proxima_dose' => $_POST['proxima_dose'] ?? null,
            'quantidade' => trim($_POST['quantidade'] ?? '')
        ];
    }

    private function validarDadosVacinacao($dados)
    {
        if (
            empty($dados['animal_id']) ||
            empty($dados['vacina']) ||
            empty($dados['data_aplicacao'])
        ) {
            return 'Preencha os campos obrigatórios: animal, vacina e data de aplicação.';
        }

        if ($dados['quantidade'] === '') {
            return 'Informe a quantidade/dose aplicada.';
        }

        if (!is_numeric($dados['quantidade']) || (float) $dados['quantidade'] <= 0) {
            return 'Informe uma quantidade/dose maior que zero.';
        }

        if (!empty($dados['data_aplicacao']) && $dados['data_aplicacao'] > date('Y-m-d')) {
            return 'A data de aplicação não pode ser futura.';
        }

        if (
            !empty($dados['proxima_dose']) &&
            $dados['proxima_dose'] < $dados['data_aplicacao']
        ) {
            return 'A próxima dose não pode ser anterior à data de aplicação.';
        }

        $animalModel = $this->model('Animal');

        $animal = $animalModel->buscarPorId($dados['animal_id']);

        if (!$animal) {
            return 'Animal não encontrado.';
        }

        $statusAnimal = strtolower(trim($animal['status'] ?? ''));

        if ($statusAnimal !== 'ativo') {
            return 'Não é possível registrar vacinação para animal vendido ou morto.';
        }

        return null;
    }

    private function isAjax()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}