<?php

session_start();

// Config
require_once "../app/config/config.php";
require_once "../app/config/database.php";

// Router (OBRIGATÓRIO ser o último)
require_once "../app/routes/web.php";