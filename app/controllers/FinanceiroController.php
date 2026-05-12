<?php

class FinanceiroController extends Controller
{
    public function index()
    {
        $this->render('financeiro/financeiro', [
            'titulo' => 'GranBoi - Financeiro'
        ]);
    }
}