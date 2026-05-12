<?php

class VacinaController extends Controller
{
    public function listar()
    {
        $this->requireRole(['administrador', 'veterinario']);

        // futuramente: buscar no model
        $vacinas = [];

        $this->render("vacinas/vacinas", [
            "vacinas" => $vacinas
        ]);
    }

    public function cadastrar()
    {
        $this->requireRole(['administrador', 'veterinario']);

        // futuro
    }

    public function salvar()
    {
        $this->requireRole(['administrador', 'veterinario']);

        // futuro
    }
}
