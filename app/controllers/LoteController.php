<?php

class LoteController extends Controller
{
    private function redirectLotes()
    {
        $this->redirect('/racas?aba=lotes');
    }

    public function index()
    {
        $this->redirectLotes();
    }

    public function salvar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectLotes();
        }

        $nome_lote = trim($_POST['nome_lote'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');

        if ($nome_lote === '') {
            $_SESSION['erro'] = 'Informe o nome do lote.';
            $this->redirectLotes();
        }

        $model = $this->model('Lote');

        if ($model->nomeExiste($nome_lote)) {
            $_SESSION['erro'] = 'Já existe um lote cadastrado com esse nome.';
            $this->redirectLotes();
        }

        try {
            $model->salvar([
                'nome_lote' => $nome_lote,
                'descricao' => $descricao
            ]);

            $_SESSION['sucesso'] = 'Lote cadastrado com sucesso.';
            $this->redirectLotes();

        } catch (PDOException $e) {
            $_SESSION['erro'] = 'Erro ao cadastrar lote. Tente novamente.';
            $this->redirectLotes();
        }
    }

    public function atualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectLotes();
        }

        $id = $_POST['id'] ?? null;
        $nome_lote = trim($_POST['nome_lote'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');

        if (empty($id) || $nome_lote === '') {
            $_SESSION['erro'] = 'Informe os dados do lote corretamente.';
            $this->redirectLotes();
        }

        $model = $this->model('Lote');

        $lote = $model->buscarPorId($id);

        if (!$lote) {
            $_SESSION['erro'] = 'Lote não encontrado.';
            $this->redirectLotes();
        }

        if ($model->nomeExiste($nome_lote, $id)) {
            $_SESSION['erro'] = 'Já existe outro lote cadastrado com esse nome.';
            $this->redirectLotes();
        }

        try {
            $model->atualizar([
                'id' => $id,
                'nome_lote' => $nome_lote,
                'descricao' => $descricao
            ]);

            $_SESSION['sucesso'] = 'Lote atualizado com sucesso.';
            $this->redirectLotes();

        } catch (PDOException $e) {
            $_SESSION['erro'] = 'Erro ao atualizar lote. Tente novamente.';
            $this->redirectLotes();
        }
    }

    public function excluir()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectLotes();
        }

        $id = $_POST['id'] ?? null;

        if (empty($id)) {
            $_SESSION['erro'] = 'Lote não informado.';
            $this->redirectLotes();
        }

        $model = $this->model('Lote');

        $lote = $model->buscarPorId($id);

        if (!$lote) {
            $_SESSION['erro'] = 'Lote não encontrado.';
            $this->redirectLotes();
        }

        if ($model->estaEmUso($id)) {
            $_SESSION['erro'] = 'Não é possível excluir este lote, pois ele está vinculado a um ou mais animais.';
            $this->redirectLotes();
        }

        try {
            $model->excluir($id);

            $_SESSION['sucesso'] = 'Lote excluído com sucesso.';
            $this->redirectLotes();

        } catch (PDOException $e) {
            $_SESSION['erro'] = 'Erro ao excluir lote. Tente novamente.';
            $this->redirectLotes();
        }
    }
}