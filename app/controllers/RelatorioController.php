<?php

class RelatorioController extends Controller
{
    public function index()
    {
        $this->render('relatorios/relatorios', [
            'titulo' => 'GranBoi - Relatórios',
            'pageCss' => [
                '/public/assets/css/pages/relatorios/relatorios.css'
            ],
            'pageJs' => [
                '/public/assets/js/pages/relatorios/relatorios.js'
            ]
        ]);
    }
}