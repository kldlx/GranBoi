<?php

session_start();

define('ROOT_PATH', __DIR__);



require_once ROOT_PATH . '/app/config/config.php';
require_once ROOT_PATH . '/app/config/database.php';

require_once ROOT_PATH . '/app/routes/web.php';