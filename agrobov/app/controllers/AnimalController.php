<?php
// app/controllers/boiController.php
use App\Models\Boi;

class boiController extends Controller {
    
    public function cadastro() {
        // Carrega a view de formulário (que está em views/boi/cadastroBoi.php)
        $this->render("home/homeGranboi");
    }

    public function salvar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $model = new Boi();
            $dados = [
                'brinco'     => $_POST['brinco'],
                'raca'       => $_POST['raca_id'],
                'lote'       => $_POST['lote_id'],
                'nascimento' => $_POST['data_nascimento'],
                'sexo'       => $_POST['sexo'],
                'peso'       => $_POST['peso_entrada']
            ];

            if ($model->salvar($dados)) {
                header("Location: " . BASE_URL . "boi/verBoi");
            }
        }
    }
}