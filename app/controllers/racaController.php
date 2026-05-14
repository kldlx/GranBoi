<?php

class RacaController extends Controller
{
    public function index()
    {
        $racaModel = $this->model('Raca');
        $loteModel = $this->model('Lote');

        $dados = [
            'titulo' => 'GranBoi - Cadastros',
            'tituloPagina' => 'Cadastros',
            'subtituloPagina' => 'Gerencie as raças e os lotes cadastrados no sistema',
            'pageCss' => [
                '/public/assets/css/pages/cadastros/cadastros.css'
            ],
            'pageJs' => [
                '/public/assets/js/pages/cadastros/cadastrosPage.js'
            ],
            'racas' => $racaModel->listarTodos(),
            'lotes' => $loteModel->listarTodos()
        ];

        $this->render('racas/listar', $dados);
    }

    public function listar()
    {
        $this->index();
    }

    public function salvar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/racas');
        }

        $nome_raca = trim($_POST['nome_raca'] ?? '');

        if ($nome_raca === '') {
            $_SESSION['erro'] = 'Informe o nome da raça.';
            $this->redirect('/racas');
        }

        $model = $this->model('Raca');

        if ($model->nomeExiste($nome_raca)) {
            $_SESSION['erro'] = 'Já existe uma raça cadastrada com esse nome.';
            $this->redirect('/racas');
        }

        try {
            $model->salvar([
                'nome_raca' => $nome_raca
            ]);

            $_SESSION['sucesso'] = 'Raça cadastrada com sucesso.';
            $this->redirect('/racas');

        } catch (PDOException $e) {
            $_SESSION['erro'] = 'Erro ao cadastrar raça. Tente novamente.';
            $this->redirect('/racas');
        }
    }

    public function atualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/racas');
        }

        $id = $_POST['id'] ?? null;
        $nome_raca = trim($_POST['nome_raca'] ?? '');

        if (empty($id) || $nome_raca === '') {
            $_SESSION['erro'] = 'Informe os dados da raça corretamente.';
            $this->redirect('/racas');
        }

        $model = $this->model('Raca');

        $raca = $model->buscarPorId($id);

        if (!$raca) {
            $_SESSION['erro'] = 'Raça não encontrada.';
            $this->redirect('/racas');
        }

        if ($model->nomeExiste($nome_raca, $id)) {
            $_SESSION['erro'] = 'Já existe outra raça cadastrada com esse nome.';
            $this->redirect('/racas');
        }

        try {
            $model->atualizar([
                'id' => $id,
                'nome_raca' => $nome_raca
            ]);

            $_SESSION['sucesso'] = 'Raça atualizada com sucesso.';
            $this->redirect('/racas');

        } catch (PDOException $e) {
            $_SESSION['erro'] = 'Erro ao atualizar raça. Tente novamente.';
            $this->redirect('/racas');
        }
    }

    public function excluir()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/racas');
        }

        $id = $_POST['id'] ?? null;

        if (empty($id)) {
            $_SESSION['erro'] = 'Raça não informada.';
            $this->redirect('/racas');
        }

        $model = $this->model('Raca');

        $raca = $model->buscarPorId($id);

        if (!$raca) {
            $_SESSION['erro'] = 'Raça não encontrada.';
            $this->redirect('/racas');
        }

        if ($model->estaEmUso($id)) {
            $_SESSION['erro'] = 'Não é possível excluir esta raça, pois ela está vinculada a um ou mais animais.';
            $this->redirect('/racas');
        }

        try {
            $model->excluir($id);

            $_SESSION['sucesso'] = 'Raça excluída com sucesso.';
            $this->redirect('/racas');

        } catch (PDOException $e) {
            $_SESSION['erro'] = 'Erro ao excluir raça. Tente novamente.';
            $this->redirect('/racas');
        }
    }
}