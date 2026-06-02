<?php

class FinanceiroController extends Controller
{
    public function index()
    {
        $financeiro = $this->model('Financeiro');
        $loteModel  = $this->model('Lote');

        $totalReceitas      = $financeiro->getTotalReceitas();
        $totalSanitario     = $financeiro->getTotalCustosSanitarios();
        $totalManejo        = $financeiro->getTotalCustosManejo();
        $totalPasto         = $financeiro->getTotalCustosPasto();
        $totalOperacional   = $financeiro->getTotalDespesasOperacionais();
        $totalDespesas      = $totalSanitario + $totalManejo + $totalPasto + $totalOperacional;
        $resultado          = $totalReceitas - $totalDespesas;

        $this->render('financeiro/financeiro', [
            'titulo'                  => 'GranBoi - Financeiro',
            'pageCss'                 => ['/public/assets/css/pages/financeiro/financeiro.css'],
            'pageJs'                  => ['/public/assets/js/pages/financeiro/financeiro.js'],
            'totalReceitas'           => $totalReceitas,
            'totalSanitario'          => $totalSanitario,
            'totalManejo'             => $totalManejo,
            'totalPasto'              => $totalPasto,
            'totalOperacional'        => $totalOperacional,
            'totalDespesas'           => $totalDespesas,
            'resultado'               => $resultado,
            'ultimasVendas'           => $financeiro->getUltimasVendas(),
            'ultimosCustosSanitarios' => $financeiro->getUltimosCustosSanitarios(),
            'ultimasDespesas'         => $financeiro->getUltimasDespesas(),
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
            'Equipamento', 'Transporte', 'Manutenção', 'Outros'
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
}
