<?php
require_once '../app/Core/Router.php';

use App\Core\Router;

$router = new Router();

$router->add('GET', '/', 'LandingController', 'index');
$router->add('GET', '/student', 'StudentController', 'index');
$router->add('GET', '/student/{id}', 'StudentController', 'show');

$router->run();
?>