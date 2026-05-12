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
            'pesoMedio' => $dashboardModel->pesoMedioAtual(),
            'gmdMedio' => $dashboardModel->gmdMedio(),
            'ultimosAnimais' => $dashboardModel->ultimosAnimais(5)
        ]);
    }
}