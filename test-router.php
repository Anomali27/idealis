<?php
/**
 * Simple Router Test
 */

// Register autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/app/';
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});

// Test router
require_once __DIR__ . '/app/core/Router.php';

use App\Core\Router;

$router = new Router();

$router->add('GET', '/', 'LandingController', 'index');
$router->add('GET', '/auth/login', 'AuthController', 'login');

echo "Routes registered successfully!\n";
echo "Testing route matching...\n";

// Simulate request
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/auth/login';

echo "Request URI: " . $_SERVER['REQUEST_URI'] . "\n";

// Test route matching manually
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($uri, '/');
if ($uri === '') $uri = '/';

foreach ($router->getRoutes() as $route) {
    $pattern = str_replace('{id}', '([0-9]+)', $route['uri']);
    $pattern = '#^' . $pattern . '$#';
    
    if (preg_match($pattern, $uri, $matches)) {
        echo "MATCH FOUND!\n";
        echo "Route: " . $route['uri'] . "\n";
        echo "Controller: " . $route['controller'] . "\n";
        echo "Function: " . $route['function'] . "\n";
        
        // Try to load the controller
        $controllerFile = __DIR__ . '/app/controllers/' . $route['controller'] . '.php';
        echo "Controller file: " . $controllerFile . "\n";
        echo "File exists: " . (file_exists($controllerFile) ? 'YES' : 'NO') . "\n";
        
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $controllerClass = 'App\\Controllers\\' . $route['controller'];
            echo "Class to instantiate: " . $controllerClass . "\n";
            
            if (class_exists($controllerClass)) {
                echo "Class EXISTS!\n";
            } else {
                echo "Class does NOT exist!\n";
            }
        }
    }
}

class Router {
    private $routes = [];
    
    public function add(string $method, string $uri, string $controller, string $function) {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'function' => $function,
        ];
    }
    
    public function getRoutes() {
        return $this->routes;
    }
}
