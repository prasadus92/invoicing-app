<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Config;
use App\Core\Router;
use App\Core\Database;
use App\Core\Session;

class Application
{
    public static Application $app;
    public Router $router;
    public Database $db;
    public Session $session;
    public Config $config;

    public function __construct(Config $config)
    {
        self::$app = $this;
        $this->config = $config;
        $this->router = new Router();
        $this->db = new Database($config);
        $this->session = new Session();
    }

    public function run(): void
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            $this->handleException($e);
        }
    }

    private function handleException(\Exception $e): void
    {
        if ($this->config->get('APP_DEBUG')) {
            throw $e;
        }

        // Log the error
        error_log($e->getMessage());
        
        // Show user-friendly error page
        http_response_code(500);
        require_once __DIR__ . '/../Views/errors/500.php';
    }
} 