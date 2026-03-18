<?php
namespace App\Core;

class Router
{
    private array $routes = [];

    public function add(string $method, string $uri, string $controller, string $function)
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'function' => $function,
        ];
    }

    public function run()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Normalize URI - fix double slashes
        $uri = preg_replace('#/{2,}#', '/', $uri);
        $uri = rtrim($uri, '/');
        if ($uri === '') {
            $uri = '/';
        }

        foreach ($this->routes as $route) {

            if ($method !== $route['method']) {
                continue;
            }

            $pattern = str_replace('{id}', '([0-9]+)', $route['uri']);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {

                array_shift($matches);

                require_once __DIR__ . '/../controllers/' . $route['controller'] . '.php';

                $controllerClass = 'App\\Controllers\\' . $route['controller'];
                $controller = new $controllerClass();

                $function = $route['function'];

                call_user_func_array([$controller, $function], $matches);

                return;
            }
        }

        http_response_code(404);
        echo '<h1>404 - Page Not Found</h1>';
    }
}
