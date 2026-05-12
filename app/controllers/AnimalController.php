<?php

class AnimalController extends Controller
{
    public function listar()
    {
        $model = $this->model('Animal');

        $dados = [
            'titulo' => 'GranBoi - Gado',
            'pageCss' => [
                '/public/assets/css/components/modal.css',
                '/public/assets/css/components/animal/animalModal.css',
                '/public/assets/css/pages/animal/animal.css'
            ],
            'pageJs' => [
    '/public/assets/js/validations/animal/animalValidation.js',
    '/public/assets/js/modals/animal/cadastrarAnimalModal.js',
    '/public/assets/js/modals/animal/editarAnimalModal.js',
    '/public/assets/js/modals/animal/excluirAnimalModal.js',
    '/public/assets/js/modals/animal/detalhesAnimalModal.js',
    '/public/assets/js/pages/animal/animalPage.js'
],
            'animais' => $model->listarTodos()
        ];

        $this->render('animal/listar', $dados);
    }

    public function cadastrar()
    {
        $this->redirect('/animal');
    }

    public function salvar()
    {
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => 'Requisição inválida.'
                ], 405);
            }

            $this->redirect('/animal');
        }

        $dados = [
            'brinco' => trim($_POST['brinco'] ?? ''),
            'raca' => trim($_POST['raca'] ?? ''),
            'lote' => trim($_POST['lote'] ?? ''),
            'data_nascimento' => $_POST['data_nascimento'] ?? null,
            'sexo' => $_POST['sexo'] ?? '',
            'peso_entrada' => $_POST['peso_entrada'] ?? '',
            'observacoes' => trim($_POST['observacoes'] ?? '')
        ];

        $erro = null;

        if (
            empty($dados['brinco']) ||
            empty($dados['sexo']) ||
            empty($dados['peso_entrada'])
        ) {
            $erro = 'Preencha os campos obrigatórios: brinco, sexo e peso.';
        }

        if (!$erro && (!is_numeric($dados['peso_entrada']) || $dados['peso_entrada'] <= 0)) {
            $erro = 'O peso de entrada deve ser maior que zero.';
        }

        if (!$erro && !in_array($dados['sexo'], ['Macho', 'Fêmea'])) {
            $erro = 'Selecione um sexo válido.';
        }

        if (!$erro && !empty($dados['data_nascimento'])) {
            $hoje = date('Y-m-d');

            if ($dados['data_nascimento'] > $hoje) {
                $erro = 'A data de nascimento não pode ser uma data futura.';
            }
        }

        if (empty($dados['data_nascimento'])) {
            $dados['data_nascimento'] = null;
        }

        $model = $this->model('Animal');

        if (!$erro && $model->brincoExiste($dados['brinco'])) {
            $erro = 'Já existe um animal cadastrado com esse número de brinco.';
        }

        if ($erro) {
            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => $erro
                ], 422);
            }

            $_SESSION['erro'] = $erro;
            $this->redirect('/animal');
        }

        try {
            $animalId = $model->salvar($dados);

$pesagemModel = $this->model('Pesagem');

$pesagemModel->registrar([
    'animal_id' => $animalId,
    'peso' => $dados['peso_entrada'],
    'observacao' => 'Peso inicial registrado no cadastro do animal.'
]);

if ($isAjax) {
    $this->json([
        'sucesso' => true,
        'mensagem' => 'Animal cadastrado com sucesso.'
    ]);
}

            $_SESSION['sucesso'] = 'Animal cadastrado com sucesso.';
            $this->redirect('/animal');

        } catch (PDOException $e) {
    $mensagem = 'Erro ao cadastrar animal. Verifique os dados e tente novamente.';

    if ($e->getCode() === '23000') {
        $mensagem = 'Já existe um animal cadastrado com esse número de brinco.';
    }

    if ($isAjax) {
        $this->json([
            'sucesso' => false,
            'mensagem' => $mensagem
        ], 500);
    }

    $_SESSION['erro'] = $mensagem;
    $this->redirect('/animal');
}
    }

    public function editar()
    {
        $this->redirect('/animal');
    }

    public function atualizar()
    {
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => 'Requisição inválida.'
                ], 405);
            }

            $this->redirect('/animal');
        }

        $dados = [
            'id' => $_POST['id'] ?? '',
            'brinco' => trim($_POST['brinco'] ?? ''),
            'raca' => trim($_POST['raca'] ?? ''),
            'lote' => trim($_POST['lote'] ?? ''),
            'data_nascimento' => $_POST['data_nascimento'] ?? null,
            'sexo' => $_POST['sexo'] ?? '',
            'peso_entrada' => $_POST['peso_entrada'] ?? '',
            'status' => $_POST['status'] ?? 'ativo',
            'observacoes' => trim($_POST['observacoes'] ?? '')
        ];

        $erro = null;

        if (
            empty($dados['id']) ||
            empty($dados['brinco']) ||
            empty($dados['sexo']) ||
            empty($dados['status'])
        ) {
            $erro = 'Preencha os campos obrigatórios: brinco, sexo e status.';
        }


        if (!$erro && !in_array($dados['sexo'], ['Macho', 'Fêmea'])) {
            $erro = 'Selecione um sexo válido.';
        }

        if (!$erro && !in_array($dados['status'], ['ativo', 'vendido', 'morto'])) {
            $erro = 'Selecione um status válido.';
        }

        if (!$erro && !empty($dados['data_nascimento'])) {
            $hoje = date('Y-m-d');

            if ($dados['data_nascimento'] > $hoje) {
                $erro = 'A data de nascimento não pode ser uma data futura.';
            }
        }

        if (empty($dados['data_nascimento'])) {
            $dados['data_nascimento'] = null;
        }

        if ($erro) {
            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => $erro
                ], 422);
            }

            $_SESSION['erro'] = $erro;
            $this->redirect('/animal');
        }

        $model = $this->model('Animal');

        try {
            $model->atualizar($dados);

            if ($isAjax) {
                $this->json([
                    'sucesso' => true,
                    'mensagem' => 'Animal atualizado com sucesso.'
                ]);
            }

            $_SESSION['sucesso'] = 'Animal atualizado com sucesso.';
            $this->redirect('/animal');

        } catch (PDOException $e) {
            $mensagem = 'Erro ao atualizar animal. Verifique os dados e tente novamente.';

            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => $mensagem
                ], 500);
            }

            $_SESSION['erro'] = $mensagem;
            $this->redirect('/animal');
        }
    }

    public function excluir()
    {
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => 'Requisição inválida.'
                ], 405);
            }

            $this->redirect('/animal');
        }

        $id = $_POST['id'] ?? null;

        if (empty($id)) {
            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => 'Animal não informado.'
                ], 422);
            }

            $_SESSION['erro'] = 'Animal não informado.';
            $this->redirect('/animal');
        }

        $model = $this->model('Animal');

        $animal = $model->buscarPorId($id);

        if (!$animal) {
            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => 'Animal não encontrado.'
                ], 404);
            }

            $_SESSION['erro'] = 'Animal não encontrado.';
            $this->redirect('/animal');
        }

        try {
            $model->softDelete($id);

            if ($isAjax) {
                $this->json([
                    'sucesso' => true,
                    'mensagem' => 'Animal excluído com sucesso.'
                ]);
            }

            $_SESSION['sucesso'] = 'Animal excluído com sucesso.';
            $this->redirect('/animal');

        } catch (PDOException $e) {
            $mensagem = 'Erro ao excluir animal. Tente novamente.';

            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => $mensagem
                ], 500);
            }

            $_SESSION['erro'] = $mensagem;
            $this->redirect('/animal');
        }
    }

    public function detalhes()
    {
        $this->redirect('/animal');
    }

    public function historicoPeso()
{
    $id = $_GET['id'] ?? $_GET['animal_id'] ?? null;

    if ($id) {
        $this->redirect('/peso?animal_id=' . $id);
    }

    $this->redirect('/peso');
}
}