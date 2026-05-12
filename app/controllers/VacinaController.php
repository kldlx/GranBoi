<?php

class VacinaController extends Controller
{
    public function listar()
    {
        $vacinas = [];

        $this->render('vacinas/vacinas', [
            'titulo' => 'GranBoi - Vacinação',
            'vacinas' => $vacinas
        ]);
    }

    public function cadastrar()
    {
        $this->redirect('/vacinas');
    }

    public function salvar()
    {
        $this->redirect('/vacinas');
    }
}