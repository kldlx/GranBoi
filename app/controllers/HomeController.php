<?php

class HomeController extends Controller
{
    public function dashboard()
    {
        $this->requireLogin();

        $this->render('dashboard/dashboard');
    }
}
