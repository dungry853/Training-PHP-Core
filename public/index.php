<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Session;


Session::start();

use App\Core\Router;


require_once __DIR__ . '/../routes/web.php';

Router::dispatch();
