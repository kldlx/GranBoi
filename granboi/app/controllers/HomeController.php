<?php

class HomeController extends Controller
{
    public function dashboard()
    {
        if (!isset($_SESSION['user'])) {

            header('Location: ' . BASE_URL . '/login');
            exit;

        }

        $this->render('dashboard/dashboard');
    }
}