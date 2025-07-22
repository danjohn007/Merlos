<?php
/**
 * Router class for handling URL routing
 */
class Router {
    private $routes = [];
    
    public function add($pattern, $controller, $action, $method = 'GET') {
        $this->routes[] = [
            'pattern' => $pattern,
            'controller' => $controller,
            'action' => $action,
            'method' => $method
        ];
    }
    
    public function dispatch() {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        
        // Remove query string from URI
        $uri = parse_url($requestUri, PHP_URL_PATH);
        
        // Remove base path if application is in subdirectory
        $basePath = dirname($_SERVER['SCRIPT_NAME']);
        if ($basePath !== '/' && strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }
        
        // Ensure URI starts with /
        if (substr($uri, 0, 1) !== '/') {
            $uri = '/' . $uri;
        }
        
        foreach ($this->routes as $route) {
            if ($route['method'] !== $requestMethod) {
                continue;
            }
            
            $pattern = $route['pattern'];
            
            // Convert route pattern to regex
            $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $pattern);
            $pattern = '/^' . str_replace('/', '\/', $pattern) . '$/';
            
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Remove full match
                
                $controllerName = $route['controller'];
                $actionName = $route['action'];
                
                $controllerFile = CONTROLLERS_PATH . '/' . $controllerName . '.php';
                
                if (file_exists($controllerFile)) {
                    require_once $controllerFile;
                    
                    $controller = new $controllerName();
                    
                    if (method_exists($controller, $actionName)) {
                        call_user_func_array([$controller, $actionName], $matches);
                        return;
                    }
                }
                
                $this->notFound();
            }
        }
        
        $this->notFound();
    }
    
    private function notFound() {
        http_response_code(404);
        echo "<h1>404 - Page Not Found</h1>";
        exit();
    }
}