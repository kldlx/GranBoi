<?php

class FinanceiroController extends Controller
{
    public function index()
    {
        $this->render('financeiro/financeiro', [
            'titulo' => 'GranBoi - Financeiro',
            'pageCss' => [
                '/public/assets/css/pages/financeiro/financeiro.css'
            ],
            'pageJs' => [
                '/public/assets/js/pages/financeiro/financeiro.js'
            ]
        ]);
    }
}