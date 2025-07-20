<?php
// core/Router.php
require_once __DIR__ . '/../utils/config.php';

class Router {
    private $routes = [];

    public function add($method, $path, $callback) {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'callback' => $callback
        ];
    }

    public function dispatch() {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $basePath = parse_url(APP_URL, PHP_URL_PATH);
        
        // Remover base path si existe
        if ($basePath && strpos($requestUri, $basePath) === 0) {
            $requestUri = substr($requestUri, strlen($basePath));
        }

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && $route['path'] === $requestUri) {
                return $this->callHandler($route['callback']);
            }
        }

        // Ruta no encontrada
        http_response_code(404);
        require VIEWS_DIR . 'errors/404.php';
        exit;
    }

    private function callHandler($callback) {
        if (is_callable($callback)) {
            return call_user_func($callback);
        }
        
        if (is_string($callback)) {
            [$controller, $method] = explode('@', $callback);
            if (class_exists($controller) && method_exists($controller, $method)) {
                $controllerInstance = new $controller();
                return $controllerInstance->$method();
            }
        }
        
        throw new Exception("Controlador no válido: " . print_r($callback, true));
    }
}