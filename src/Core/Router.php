<?php

declare(strict_types=1);

namespace App\Core;

class Router
{
    private array $routes = [];
    private array $params = [];

    public function get(string $path, array $callback): void
    {
        $this->addRoute('GET', $path, $callback);
    }

    public function post(string $path, array $callback): void
    {
        $this->addRoute('POST', $path, $callback);
    }

    public function put(string $path, array $callback): void
    {
        $this->addRoute('PUT', $path, $callback);
    }

    public function delete(string $path, array $callback): void
    {
        $this->addRoute('DELETE', $path, $callback);
    }

    private function addRoute(string $method, string $path, array $callback): void
    {
        $path = trim($path, '/');
        $this->routes[$method][$path] = $callback;
    }

    public function resolve()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        
        $callback = $this->routes[$method][$path] ?? null;

        if ($callback === null) {
            throw new \Exception('Page not found', 404);
        }

        if (is_array($callback)) {
            [$class, $method] = $callback;
            if (class_exists($class)) {
                $class = new $class();
                if (method_exists($class, $method)) {
                    return call_user_func([$class, $method]);
                }
            }
        }

        throw new \Exception('Invalid route handler', 500);
    }
} 