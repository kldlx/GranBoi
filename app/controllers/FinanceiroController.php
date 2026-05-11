<?php

require_once "Controller.php";

class FinanceiroController extends Controller
{
    public function index()
    {
        return $this->render("financeiro/financeiro");
    }

    public function listarReceitas()
    {
        return $this->render("financeiro/listarReceitas");
    }

    public function listarDespesas()
    {
        return $this->render("financeiro/listarDespesas");
    }

    public function novaTransacao()
    {
        // ainda vazio
    }
}