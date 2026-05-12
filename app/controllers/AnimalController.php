<?php

class AnimalController extends Controller
{
    public function listar()
{
    $model = $this->model('Animal');

    $dados = [
        'titulo' => 'GranBoi - Gado',
        'pageCss' => [
            '/public/assets/css/pages/animal/animal.css'
        ],
        'animais' => $model->listarTodos()
    ];

    $this->render('animal/listar', $dados);
}

    public function cadastrar()
    {
        $this->render("animal/cadastrar");
    }

    public function salvar()
    {
        // POST - salvar animal (futuro)
    }

    public function editar()
{
    $model = $this->model('Animal');;

    $id = $_GET['id'] ?? null;

    if (!$id) {
        header("Location: /animal/listar");
        exit;
    }

    $animal = $model->buscarPorId($id);

    $this->render("animal/editar", [
        'animal' => $animal
    ]);
}

public function atualizar()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $model = $this->model('Animal');;

        $dados = [
            'id' => $_POST['id'],
            'brinco' => $_POST['brinco'],
            'sexo' => $_POST['sexo'],
            'peso' => $_POST['peso_entrada'],
            'status' => $_POST['status']
        ];

        $model->atualizar($dados);

        header("Location: /animal/listar");
        exit;
    }
}

    public function excluir()
{
    $id = $_GET['id'] ?? null;

    if (!$id) {
        header("Location: /animal/listar");
        exit;
    }

    $model = $this->model('Animal');;
    $model->softDelete($id);

    header("Location: /animal/listar");
    exit;
}

    public function detalhes()
    {
        $this->render("animal/detalhes");
    }

    public function historicoPeso()
{
    $id = $_GET['id'] ?? null;

    $model = $this->model('Animal');;

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