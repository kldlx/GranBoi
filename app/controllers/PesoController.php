<?php

class PesoController extends Controller
{
    public function index()
    {
        $animalId = $_GET['animal_id'] ?? null;

        $animalModel = $this->model('Animal');
        $pesagemModel = $this->model('Pesagem');

        $animais = $animalModel->listarTodos();

        $animalSelecionado = null;
        $historico = [];
        $gmd = null;
        $ultimaPesagem = null;
        $pesoAtual = null;

        if ($animalId) {
            $animalSelecionado = $animalModel->buscarPorId($animalId);

            if ($animalSelecionado) {
                $historico = $pesagemModel->listarPorAnimal($animalId);
                $gmd = $pesagemModel->calcularGmd($animalId);
                $ultimaPesagem = $pesagemModel->buscarUltimaPesagem($animalId);

                $pesoAtual = $ultimaPesagem
                    ? $ultimaPesagem['peso']
                    : $animalSelecionado['peso_entrada'];
            }
        }

        $this->render('peso/peso', [
            'titulo' => 'GranBoi - Pesagem',
            'pageCss' => [
                '/public/assets/css/pages/peso/peso.css'
            ],
            'pageJs' => [
                '/public/assets/js/pages/peso/pesoPage.js'
            ],
            'animais' => $animais,
            'animalSelecionado' => $animalSelecionado,
            'historico' => $historico,
            'gmd' => $gmd,
            'ultimaPesagem' => $ultimaPesagem,
            'pesoAtual' => $pesoAtual
        ]);
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
            'animal_id' => $_POST['animal_id'] ?? '',
            'peso' => $_POST['peso'] ?? '',
            'observacao' => trim($_POST['observacao'] ?? ''),
            'data_pesagem' => $_POST['data_pesagem'] ?? ''
        ];

        $erro = null;

        if (empty($dados['animal_id']) || empty($dados['peso'])) {
            $erro = 'Informe o animal e o peso.';
        }

        if (!$erro && (!is_numeric($dados['peso']) || $dados['peso'] <= 0)) {
            $erro = 'O peso deve ser maior que zero.';
        }

        $animalModel = $this->model('Animal');

        if (!$erro) {
            $animal = $animalModel->buscarPorId($dados['animal_id']);

            if (!$animal) {
                $erro = 'Animal não encontrado.';
            } elseif (strtolower(trim($animal['status'] ?? '')) !== 'ativo') {
                $erro = 'Não é possível registrar pesagem para animal vendido ou perdido.';
            }
        }

        if ($erro) {
            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => $erro
                ], 422);
            }

            $_SESSION['erro'] = $erro;
            $this->redirect('/peso?animal_id=' . ($dados['animal_id'] ?? ''));
        }

        try {
            $pesagemModel = $this->model('Pesagem');

            $pesagemModel->registrar($dados);

            if ($isAjax) {
                $this->json([
                    'sucesso' => true,
                    'mensagem' => 'Pesagem registrada com sucesso.'
                ]);
            }

            $_SESSION['sucesso'] = 'Pesagem registrada com sucesso.';
            $this->redirect('/peso?animal_id=' . $dados['animal_id']);

        } catch (PDOException $e) {
            $mensagem = 'Erro ao registrar pesagem. Tente novamente.';

            if ($isAjax) {
                $this->json([
                    'sucesso' => false,
                    'mensagem' => $mensagem
                ], 500);
            }

            $_SESSION['erro'] = $mensagem;
            $this->redirect('/peso?animal_id=' . ($dados['animal_id'] ?? ''));
        }
    }

    public function historico()
    {
        $animalId = $_GET['animal_id'] ?? null;

        if (!$animalId) {
            $this->redirect('/animal');
        }

        $animalModel = $this->model('Animal');
        $pesagemModel = $this->model('Pesagem');

        $animal = $animalModel->buscarPorId($animalId);

        if (!$animal) {
            $this->redirect('/animal');
        }

        $historico = $pesagemModel->listarPorAnimal($animalId);
        $gmd = $pesagemModel->calcularGmd($animalId);

        $this->render('peso/historico', [
            'titulo' => 'GranBoi - Histórico de Peso',
            'animal' => $animal,
            'historico' => $historico,
            'gmd' => $gmd
        ]);
    }
}