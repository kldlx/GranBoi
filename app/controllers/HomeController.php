<?php

class HomeController extends Controller
{
    public function dashboard()
    {
        $this->render('dashboard/dashboard', [
            'titulo' => 'GranBoi - Dashboard',
            'pageCss' => [
                '/public/assets/css/pages/dashboard/dashboard.css'
            ],
            'pageJs' => [
                '/public/assets/js/pages/dashboard/dashboard.js'
            ]
        ]);
    }
}