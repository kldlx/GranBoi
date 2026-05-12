<?php

require_once __DIR__ . '/../models/conexao.php';
require_once __DIR__ . '/../models/Animal.php';

class AnimalController extends Controller
{
    public function listar()
{
    $this->requireRole(['administrador', 'gestor', 'veterinario', 'operador']);

    $model = new Animal();

    $dados = [
        'animais' => $model->listarTodos()
    ];

    $this->render("animal/listar", $dados);
}

    public function cadastrar()
    {
        $this->requireRole(['administrador', 'gestor', 'operador']);

        $this->render("animal/cadastrar");
    }

public function salvar()
{
    $this->requireRole(['administrador', 'gestor', 'operador']);

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: " . BASE_URL . "/animal/cadastrar");
        exit;
    }

    $model = new Animal();

    $dados = [
        ':brinco' => $_POST['brinco'] ?? null,
        ':raca' => $_POST['raca'] ?? null,
        ':lote' => $_POST['lote'] ?? null,
        ':nascimento' => !empty($_POST['nascimento']) ? $_POST['nascimento'] : null,
        ':sexo' => $_POST['sexo'] ?? null,
        ':peso' => $_POST['peso'] ?? null
    ];

    try {
        $model->salvar($dados);

        header("Location: " . BASE_URL . "/animal/listar?sucesso=cadastrado");
        exit;

    } catch (PDOException $e) {

        $mensagemErro = $e->getMessage();

        if (
            str_contains($mensagemErro, '1062') ||
            str_contains($mensagemErro, 'brinco_UNIQUE') ||
            str_contains($mensagemErro, 'Duplicate entry')
        ) {
            header("Location: " . BASE_URL . "/animal/cadastrar?erro=brinco_duplicado");
            exit;
        }

        header("Location: " . BASE_URL . "/animal/cadastrar?erro=cadastro");
        exit;
    }
}

    public function editar()
{
    $this->requireRole(['administrador', 'gestor', 'operador']);

    $model = new Animal();

    $id = $_GET['id'] ?? null;

    if (!$id) {
        header("Location: " . BASE_URL . "/animal/listar");
        exit;
    }

    $animal = $model->buscarPorId($id);

    $this->render("animal/editar", [
        'animal' => $animal
    ]);
}

public function atualizar()
{
    $this->requireRole(['administrador', 'gestor', 'operador']);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $model = new Animal();

        $dados = [
            'id' => $_POST['id'],
            'brinco' => $_POST['brinco'],
            'sexo' => $_POST['sexo'],
            'peso' => $_POST['peso_entrada'],
            'status' => $_POST['status']
        ];

        $model->atualizar($dados);

        header("Location: " . BASE_URL . "/animal/listar");
        exit;
    }
}

    public function excluir()
{
    $this->requireRole(['administrador']);

    $id = $_GET['id'] ?? null;

    if (!$id) {
        header("Location: " . BASE_URL . "/animal/listar");
        exit;
    }

    $model = new Animal();
    $model->softDelete($id);

    header("Location: " . BASE_URL . "/animal/listar");
    exit;
}

public function adicionarPeso()
{
    $this->requireRole(['administrador', 'gestor', 'operador']);

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: " . BASE_URL . "/animal/listar");
        exit;
    }

    $animalId = $_POST['animal_id'] ?? null;
    $peso = $_POST['peso'] ?? null;

    if (!$animalId || !$peso) {
        header("Location: " . BASE_URL . "/animal/listar");
        exit;
    }

    $model = new Animal();
    $model->adicionarPeso($animalId, $peso);

    header("Location: " . BASE_URL . "/animal/historicoPeso?id=" . $animalId);
    exit;
}

    public function detalhes()
    {
        $this->requireRole(['administrador', 'gestor', 'veterinario', 'operador']);

        $this->render("animal/detalhes");
    }

    public function historicoPeso()
{
    $this->requireRole(['administrador', 'gestor', 'veterinario', 'operador']);

    $id = $_GET['id'] ?? null;

    $model = new Animal();

    $historico = $model->getHistoricoPeso($id);

    $pesos = [];
    $datas = [];

    foreach ($historico as $item) {
        $pesos[] = $item['peso'];
        $datas[] = date('d/m', strtotime($item['data_registro']));
    }

    $this->render("animal/historicoPeso", [
        'animal' => $model->buscarPorId($id),
        'pesos' => $pesos,
        'datas' => $datas,
        'historico' => $historico
    ]);
}
}
