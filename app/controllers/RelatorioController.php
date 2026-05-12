<?php

require_once "Controller.php";

class RelatorioController extends Controller
{
    public function index()
    {
        $this->requireRole(['administrador', 'gestor']);

        return $this->render("relatorios/relatorios");
    }
}
