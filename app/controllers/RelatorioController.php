<?php

class RelatorioController extends Controller
{
    public function index()
    {
        $relatorioModel = $this->model('Relatorio');

        $dataInicio = $_GET['data_inicio'] ?? date('Y-m-01');
        $dataFim = $_GET['data_fim'] ?? date('Y-m-d');

        if (!empty($dataInicio) && !empty($dataFim) && $dataInicio > $dataFim) {
            $dataInicio = date('Y-m-01');
            $dataFim = date('Y-m-d');

            $_SESSION['erro'] = 'Período inválido. A data inicial não pode ser maior que a data final.';
        }

        $resumoRebanho = $relatorioModel->resumoRebanho();
        $pesoMedioAtual = $relatorioModel->pesoMedioAtual();

        $this->render('relatorios/relatorios', [
            'titulo' => 'GranBoi - Relatórios',
            'pageCss' => [
                '/public/assets/css/pages/relatorios/relatorios.css'
            ],
            'pageJs' => [
                '/public/assets/js/pages/relatorios/relatorios.js'
            ],

            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,

            'resumoRebanho' => $resumoRebanho,
            'pesoMedioAtual' => $pesoMedioAtual,
            'animaisPorRaca' => $relatorioModel->animaisPorRaca(),
            'animaisPorLote' => $relatorioModel->animaisPorLote(),
            'rankingGanhoPeso' => $relatorioModel->rankingGanhoPeso(10),
            'vacinacoesPeriodo' => $relatorioModel->vacinacoesPorPeriodo($dataInicio, $dataFim),
            'vacinasPendentes' => $relatorioModel->vacinasPendentes(),
            'vacinasAtrasadas' => $relatorioModel->vacinasAtrasadas()
        ]);
    }
}