<?php
require_once '../app/core/Router.php';

use App\Core\Router;

$router = new Router();

//Register Routes
$router->add('GET','/testing', 'TestingController', 'testing');


$router->run();
?>