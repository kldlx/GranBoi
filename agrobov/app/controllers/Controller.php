<?php
class Controller
{
protected function render($view, $dados = [])
{
extract($dados);
require_once __DIR__ . "/../views/layout/cabecalho.php";
require_once __DIR__ . "/../views/$view.php";
require_once __DIR__ . "/../views/layout/rodape.php";
}
}
?>
