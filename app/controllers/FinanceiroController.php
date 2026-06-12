<?php

class FinanceiroController extends Controller
{
    public function index()
    {
        $financeiro = $this->model('Financeiro');
        $loteModel  = $this->model('Lote');

        $isAdministrador = ($_SESSION['usuario']['papel'] ?? '') === 'administrador';

        $totalReceitas = 0;
        $totalSanitario = 0;
        $totalManejo = 0;
        $totalPasto = 0;
        $totalOperacional = 0;
        $totalDespesas = 0;
        $resultado = 0;
        $ultimasVendas = [];
        $ultimosCustosSanitarios = [];
        $ultimasDespesas = [];

        if ($isAdministrador) {
            $totalReceitas      = $financeiro->getTotalReceitas();
            $totalSanitario     = $financeiro->getTotalCustosSanitarios();
            $totalManejo        = $financeiro->getTotalCustosManejo();
            $totalPasto         = $financeiro->getTotalCustosPasto();
            $totalOperacional   = $financeiro->getTotalDespesasOperacionais();
            $totalDespesas      = $totalSanitario + $totalManejo + $totalPasto + $totalOperacional;
            $resultado          = $totalReceitas - $totalDespesas;
            $ultimasVendas      = $financeiro->getUltimasVendas();
            $ultimosCustosSanitarios = $financeiro->getUltimosCustosSanitarios();
            $ultimasDespesas    = $financeiro->getUltimasDespesas();
        }

        $this->render('financeiro/financeiro', [
            'titulo'                  => 'GranBoi - Financeiro',
            'pageCss'                 => ['/public/assets/css/pages/financeiro/financeiro.css'],
            'pageJs'                  => ['/public/assets/js/pages/financeiro/financeiro.js'],
            'isAdministrador'         => $isAdministrador,
            'totalReceitas'           => $totalReceitas,
            'totalSanitario'          => $totalSanitario,
            'totalManejo'             => $totalManejo,
            'totalPasto'              => $totalPasto,
            'totalOperacional'        => $totalOperacional,
            'totalDespesas'           => $totalDespesas,
            'resultado'               => $resultado,
            'ultimasVendas'           => $ultimasVendas,
            'ultimosCustosSanitarios' => $ultimosCustosSanitarios,
            'ultimasDespesas'         => $ultimasDespesas,
            'lotes'                   => $loteModel->listarTodos(),
        ]);
    }

    public function salvarDespesa()
    {
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            if ($isAjax) {
                $this->json(['sucesso' => false, 'mensagem' => 'Requisição inválida.'], 405);
            }
            $this->redirect('/financeiro');
        }

        $categoriasValidas = [
            'Alimentação', 'Sanidade', 'Mão de obra',
            'Equipamento', 'Transporte', 'Manutenção', 'Manejo', 'Outros'
        ];

        $dados = [
            'descricao'    => trim($_POST['descricao']    ?? ''),
            'categoria'    => trim($_POST['categoria']    ?? ''),
            'valor'        => $_POST['valor']             ?? '',
            'data_despesa' => $_POST['data_despesa']      ?? '',
            'observacao'   => trim($_POST['observacao']   ?? ''),
            'animal_id'    => $_POST['animal_id']         ?? '',
            'lote_id'      => $_POST['lote_id']           ?? '',
            'usuario_id'   => $_SESSION['usuario']['id']  ?? null,
        ];

        $erro = null;

        if (empty($dados['descricao']) || empty($dados['categoria']) || empty($dados['valor']) || empty($dados['data_despesa'])) {
            $erro = 'Preencha os campos obrigatórios: descrição, categoria, valor e data.';
        }

        if (!$erro && !in_array($dados['categoria'], $categoriasValidas)) {
            $erro = 'Categoria inválida.';
        }

        if (!$erro && (!is_numeric($dados['valor']) || (float) $dados['valor'] <= 0)) {
            $erro = 'O valor deve ser maior que zero.';
        }

        if ($erro) {
            if ($isAjax) {
                $this->json(['sucesso' => false, 'mensagem' => $erro], 422);
            }
            $_SESSION['erro'] = $erro;
            $this->redirect('/financeiro');
        }

        try {
            $financeiro = $this->model('Financeiro');
            $financeiro->salvarDespesa($dados);

            if ($isAjax) {
                $this->json(['sucesso' => true, 'mensagem' => 'Despesa registrada com sucesso.']);
            }

            $_SESSION['sucesso'] = 'Despesa registrada com sucesso.';
            $this->redirect('/financeiro');

        } catch (PDOException $e) {
            $mensagem = 'Erro ao registrar despesa. Tente novamente.';

            if ($isAjax) {
                $this->json(['sucesso' => false, 'mensagem' => $mensagem], 500);
            }

            $_SESSION['erro'] = $mensagem;
            $this->redirect('/financeiro');
        }
    }

    public function editarDespesa()
    {
        $isAjax = $this->isAjax();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            if ($isAjax) $this->json(['sucesso' => false, 'mensagem' => 'Requisição inválida.'], 405);
            $this->redirect('/financeiro');
        }

        $id = $_POST['id'] ?? '';
        $dados = [
            'descricao'    => trim($_POST['descricao']   ?? ''),
            'categoria'    => trim($_POST['categoria']   ?? ''),
            'valor'        => $_POST['valor']            ?? '',
            'data_despesa' => $_POST['data_despesa']     ?? '',
            'observacao'   => trim($_POST['observacao']  ?? ''),
            'lote_id'      => $_POST['lote_id']          ?? '',
        ];

        $categoriasValidas = ['Alimentação','Sanidade','Mão de obra','Equipamento','Transporte','Manutenção','Manejo','Outros'];

        if (empty($id) || empty($dados['descricao']) || empty($dados['categoria']) || empty($dados['valor']) || empty($dados['data_despesa'])) {
            $erro = 'Preencha os campos obrigatórios.';
        } elseif (!in_array($dados['categoria'], $categoriasValidas)) {
            $erro = 'Categoria inválida.';
        } elseif (!is_numeric($dados['valor']) || (float) $dados['valor'] <= 0) {
            $erro = 'O valor deve ser maior que zero.';
        } else {
            $erro = null;
        }

        if ($erro) {
            if ($isAjax) $this->json(['sucesso' => false, 'mensagem' => $erro], 422);
            $_SESSION['erro'] = $erro;
            $this->redirect('/financeiro');
        }

        try {
            $financeiro = $this->model('Financeiro');
            if (!$financeiro->buscarDespesaPorId($id)) {
                if ($isAjax) $this->json(['sucesso' => false, 'mensagem' => 'Despesa não encontrada.'], 404);
                $this->redirect('/financeiro');
            }
            $financeiro->atualizarDespesa($id, $dados);
            if ($isAjax) $this->json(['sucesso' => true, 'mensagem' => 'Despesa atualizada com sucesso.']);
            $_SESSION['sucesso'] = 'Despesa atualizada com sucesso.';
            $this->redirect('/financeiro');
        } catch (PDOException $e) {
            if ($isAjax) $this->json(['sucesso' => false, 'mensagem' => 'Erro ao atualizar despesa.'], 500);
            $_SESSION['erro'] = 'Erro ao atualizar despesa.';
            $this->redirect('/financeiro');
        }
    }

    public function excluirDespesa()
    {
        $isAjax = $this->isAjax();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            if ($isAjax) $this->json(['sucesso' => false, 'mensagem' => 'Requisição inválida.'], 405);
            $this->redirect('/financeiro');
        }

        $id = $_POST['id'] ?? '';

        if (empty($id)) {
            if ($isAjax) $this->json(['sucesso' => false, 'mensagem' => 'Despesa não informada.'], 422);
            $this->redirect('/financeiro');
        }

        try {
            $financeiro = $this->model('Financeiro');
            if (!$financeiro->buscarDespesaPorId($id)) {
                if ($isAjax) $this->json(['sucesso' => false, 'mensagem' => 'Despesa não encontrada.'], 404);
                $this->redirect('/financeiro');
            }
            $financeiro->excluirDespesa($id);
            if ($isAjax) $this->json(['sucesso' => true, 'mensagem' => 'Despesa excluída com sucesso.']);
            $_SESSION['sucesso'] = 'Despesa excluída com sucesso.';
            $this->redirect('/financeiro');
        } catch (PDOException $e) {
            if ($isAjax) $this->json(['sucesso' => false, 'mensagem' => 'Erro ao excluir despesa.'], 500);
            $_SESSION['erro'] = 'Erro ao excluir despesa.';
            $this->redirect('/financeiro');
        }
    }

    private function isAjax()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}
