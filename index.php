<?php

session_start();

define('ROOT_PATH', __DIR__);
define('BASE_URL', 'http://localhost/Granboi');

require_once ROOT_PATH . '/app/routes/web.php';