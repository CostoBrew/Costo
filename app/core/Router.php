<?php

/**
 * Secure Router Class
 * Handles routing with security features, middleware, and CSRF protection
 */

class Router
{
    private $routes = [];
    private $middleware = [];
    private $currentRoute = null;
    private $params = [];

    /**
     * Add GET route
     */
    public function get($uri, $action, $middleware = [])
    {
        $this->addRoute('GET', $uri, $action, $middleware);
        return $this;
    }

    /**
     * Add POST route
     */
    public function post($uri, $action, $middleware = [])
    {
        $this->addRoute('POST', $uri, $action, $middleware);
        return $this;
    }

    /**
     * Add PUT route
     */
    public function put($uri, $action, $middleware = [])
    {
        $this->addRoute('PUT', $uri, $action, $middleware);
        return $this;
    }

    /**
     * Add DELETE route
     */
    public function delete($uri, $action, $middleware = [])
    {
        $this->addRoute('DELETE', $uri, $action, $middleware);
        return $this;
    }

    /**
     * Add route to routes array
     */
    private function addRoute($method, $uri, $action, $middleware = [])
    {
        $uri = $this->sanitizeUri($uri);
        
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'action' => $action,
            'middleware' => $middleware,
            'pattern' => $this->convertToPattern($uri)
        ];
    }

    /**
     * Convert URI to regex pattern for parameter matching
     */
    private function convertToPattern($uri)
    {
        // Convert {param} to named capture groups
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $uri);
        return '#^' . $pattern . '$#';
    }

    /**
     * Sanitize URI
     */
    private function sanitizeUri($uri)
    {
        $uri = trim($uri, '/');
        return '/' . $uri;
    }

    /**
     * Get current request URI
     */
    private function getCurrentUri()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        return $this->sanitizeUri($uri);
    }

    /**
     * Get current request method
     */
    private function getCurrentMethod()
    {
        // Handle method override for forms
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method'])) {
            return strtoupper($_POST['_method']);
        }
        
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Add global middleware
     */
    public function middleware($middleware)
    {
        if (is_array($middleware)) {
            $this->middleware = array_merge($this->middleware, $middleware);
        } else {
            $this->middleware[] = $middleware;
        }
        return $this;
    }

    /**
     * Resolve and dispatch route
     */
    public function resolve()
    {
        $currentUri = $this->getCurrentUri();
        $currentMethod = $this->getCurrentMethod();

        // Apply global middleware first
        foreach ($this->middleware as $middlewareClass) {
            $this->runMiddleware($middlewareClass);
        }

        foreach ($this->routes as $route) {
            if ($route['method'] === $currentMethod && preg_match($route['pattern'], $currentUri, $matches)) {
                $this->currentRoute = $route;
                
                // Extract parameters
                $this->params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                
                // Apply route-specific middleware
                foreach ($route['middleware'] as $middlewareClass) {
                    $this->runMiddleware($middlewareClass);
                }

                // Execute the action
                return $this->executeAction($route['action']);
            }
        }

        // No route found - 404
        $this->handleNotFound();
    }

    /**
     * Execute route action
     */
    private function executeAction($action)
    {
        if (is_callable($action)) {
            // Closure action
            return call_user_func_array($action, array_values($this->params));
        }

        if (is_string($action)) {
            // Controller@method format
            $parts = explode('@', $action);
            
            if (count($parts) === 2) {
                [$controllerName, $methodName] = $parts;
                return $this->callControllerMethod($controllerName, $methodName);
            }
        }

        throw new Exception("Invalid route action: " . print_r($action, true));
    }

    /**
     * Call controller method
     */
    private function callControllerMethod($controllerName, $methodName)
    {
        $controllerFile = dirname(__DIR__) . "/controller/{$controllerName}.php";
        
        if (!file_exists($controllerFile)) {
            throw new Exception("Controller file not found: {$controllerFile}");
        }

        require_once $controllerFile;

        if (!class_exists($controllerName)) {
            throw new Exception("Controller class not found: {$controllerName}");
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $methodName)) {
            throw new Exception("Method {$methodName} not found in controller {$controllerName}");
        }

        return call_user_func_array([$controller, $methodName], array_values($this->params));
    }

    /**
     * Run middleware
     */
    private function runMiddleware($middlewareClass)
    {
        if (is_string($middlewareClass)) {
            $middlewareFile = dirname(__DIR__) . "/middleware/{$middlewareClass}.php";
            
            if (file_exists($middlewareFile)) {
                require_once $middlewareFile;
                
                if (class_exists($middlewareClass)) {
                    $middleware = new $middlewareClass();
                    
                    if (method_exists($middleware, 'handle')) {
                        $middleware->handle();
                    }
                }
            }
        } elseif (is_callable($middlewareClass)) {
            call_user_func($middlewareClass);
        }
    }

    /**
     * Handle 404 Not Found
     */
    private function handleNotFound()
    {
        http_response_code(404);
        
        if (file_exists(dirname(__DIR__) . '/view/errors/404.php')) {
            require_once dirname(__DIR__) . '/view/errors/404.php';
        } else {
            echo "404 - Page Not Found";
        }
        exit();
    }

    /**
     * Get route parameters
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Get specific parameter
     */
    public function getParam($key, $default = null)
    {
        return $this->params[$key] ?? $default;
    }

    /**
     * Generate URL for named route
     */
    public function url($uri, $params = [])
    {
        $url = $uri;
        
        foreach ($params as $key => $value) {
            $url = str_replace('{' . $key . '}', $value, $url);
        }
        
        return $_ENV['APP_URL'] . $url;
    }

    /**
     * Redirect to URL
     */
    public function redirect($url, $statusCode = 302)
    {
        header("Location: {$url}", true, $statusCode);
        exit();
    }
}
