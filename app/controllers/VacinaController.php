<?php

class VacinaController extends Controller
{
    public function listar()
    {
        // futuramente: buscar no model
        $vacinas = [];

        $this->render("vacinas/vacinas", [
            "vacinas" => $vacinas
        ]);
    }

    public function cadastrar()
    {
        // futuro
    }

    public function salvar()
    {
        // futuro
    }
}