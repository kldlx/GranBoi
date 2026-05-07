<?php
session_start();
require_once "../app/config/config.php";
require_once "../app/models/conexao.php";
require_once "../app/models/boi.php"; 
require_once "../app/controllers/controller.php";

else {
    header("Location: " . BASE_URL . "home/homeGranboi");
}