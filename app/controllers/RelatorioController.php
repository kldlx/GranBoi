<?php

class RelatorioController extends Controller
{
    public function index()
    {
        $this->render('relatorios/relatorios', [
            'titulo' => 'GranBoi - Relatórios'
        ]);
    }
}