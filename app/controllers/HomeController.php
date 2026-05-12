<?php

class HomeController extends Controller
{
    public function dashboard()
    {
        $dashboardModel = $this->model('Dashboard');

        $this->render('dashboard/dashboard', [
            'titulo' => 'GranBoi - Dashboard',
            'pageCss' => [
                '/public/assets/css/pages/dashboard/dashboard.css'
            ],
            'pageJs' => [
                '/public/assets/js/pages/dashboard/dashboard.js'
            ],

            'totalAnimais' => $dashboardModel->totalAnimais(),
            'totalAtivos' => $dashboardModel->totalPorStatus('ativo'),
            'totalVendidos' => $dashboardModel->totalPorStatus('vendido'),
            'totalMortos' => $dashboardModel->totalPorStatus('morto'),

            'pesoMedio' => $dashboardModel->pesoMedioAtual(),
            'gmdMedio' => $dashboardModel->gmdMedio(),
            'vacinasPendentes' => $dashboardModel->vacinasPendentes(),

            'ultimosAnimais' => $dashboardModel->ultimosAnimais(5),
            'ultimasPesagens' => $dashboardModel->ultimasPesagens(5)
        ]);
    }
}