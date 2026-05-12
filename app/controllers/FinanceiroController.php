<?php

require_once "Controller.php";

class FinanceiroController extends Controller
{
    public function index()
    {
        $this->requireRole(['administrador', 'gestor']);

        return $this->render("financeiro/financeiro");
    }

    public function listarReceitas()
    {
        $this->requireRole(['administrador', 'gestor']);

        return $this->render("financeiro/listarReceitas");
    }

    public function listarDespesas()
    {
        $this->requireRole(['administrador', 'gestor']);

        return $this->render("financeiro/listarDespesas");
    }

    public function novaTransacao()
    {
        // ainda vazio
    }
}
