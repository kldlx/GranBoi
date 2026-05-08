<?php
// app/controllers/adminController.php
use App\Models\Admin;

class adminController extends Controller {
    
    public function cadastrarFuncioario() {
        $this->render("funcionario/cadastrarFuncionario");
    }
    public function cadastroFuncioario(){
        
        $admin = new Admin();
        $admin->setNome($_POST['nome']);
        $admin->setEmail($_POST['email']);
        $admin->setSenha($_POST['senha']);
        $admin->cadastrar();
        $this->render("funcionario/cadastrarFuncionario");
    }
}