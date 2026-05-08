<?php

require_once "Controller.php";

class RelatorioController extends Controller
{
    public function index()
    {
        // proteção de sessão (igual dashboard)
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        return $this->render("relatorios/relatorios");
    }
}