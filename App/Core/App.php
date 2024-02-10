<?php
namespace App\Core;

use function PHPSTORM_META\type;

/**
 * App class
 * @package App
 * @version 1.0.0
 * @since 1.0.0
 */
class App {
    /**
     * @var array $routes
     * @var array $getRoutes
     * @var array $postRoutes
     * @var Request $request
     * @var Response $response
     * @var array $queries
     */
    private array $getRoutes = [];
    private array $postRoutes = [];
    private Request $request;
    private Response $response;
    private array $getQueries = [];
    private array $postQueries = [];
    /**
     * Constructor
     */
    public function __construct() {
        require_once __DIR__ . "/../../libs/init.php";
        if (getLUrl() == "fmms") {
            die("You cannot access this file directly");
        } 
    }
    /**
     * Run the application
     * @return void
     */
    public function run() {
        $this->request = new Request();
        $this->response = new Response();
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $this->runGet();
        } else if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $this->runPost();
        }
        $this->response->end();
    }
    /**
     * Resolve get request
     * @param string $url
     * @param string $controller
     * @return void
     */
    public function get (string $url, string $controller) {
        if ($url == "/") {
            $this->getRoutes[""] = $controller;
        } else {
            $this->getRoutes[$url] = $controller;
        }
        if (strpos($url, "{") !== false) {
            $url_arr = explode("/", $url);
            foreach ($url_arr as $key => $value) {
                if (strpos($value, "{") !== false) {
                    $this->getQueries[$key] = str_replace(["{", "}"], "", $value);
                }
            }
        }
    }
    /**
     * Resolve post request
     * @param string $url
     * @param string $controller
     * @return void
     */
    public function post (string $url, string $controller) {
        if ($url == "/") {
            $this->postRoutes[""] = $controller;
        } else {
            $this->postRoutes[$url] = $controller;
        }
        if (strpos($url, "{") !== false) {
            $url_arr = explode("/", $url);
            foreach ($url_arr as $key => $value) {
                if (strpos($value, "{") !== false) {
                    $this->postQueries[$key] = str_replace(["{", "}"], "", $value);
                }
            }
        }
    }
    /**
     * Run get request
     * @return void
     */
    private function runGet() : void {
        $url = getUrl();
        foreach ($this->getRoutes as $route => $controller) {
            if ($route == "" && $url == "/") {
                $controller = explode("@", $controller);
                $controller[0] = "App\\Controllers\\" . $controller[0];
                $controllerObj = new $controller[0]();
                $controllerObj->{$controller[1]}(res: $this->response);
                return;
            }
            if ($this->verifyQueries($route, $url, $controller)) {
                return;
            }
        }
        $this->response->send("<b>404 Not Found</b>", 404);
    }
    /**
     * Run post request
     * @return void
     */
    private function runPost() : void {
        $url = getUrl();
        foreach ($this->postRoutes as $route => $controller) {
            if ($route == "" && $url == "/") {
                $controller = explode("@", $controller);
                $controller[0] = "App\\Controllers\\" . $controller[0];
                $controllerObj = new $controller[0]();
                $controllerObj->{$controller[1]}(res: $this->response);
                return;
            }
            if ($this->verifyQueries($route, $url, $controller)) {
                return;
            }
        }
        $this->response->send("<b>404 Not Found</b>", 404);
    }
    /**
     * Verify queries
     * @param string $route
     * @param string $url
     * @param string $controller
     * @return bool
     */
    private function verifyQueries(string $route, string $url, string $controller) : bool {
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $queries = $this->getQueries;
        } else if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $queries = $this->postQueries;
        } else {
            return false;
        }
        if (strpos($route, "{") !== false) {
            foreach ($queries as $key => $query) {
                $route = str_replace("{" . $query . "}", "([0-9]+)", $route);
            }
        }
        if (preg_match("#^" . $route . "$#", $url)) {
            
            $args = [];
            if (strpos($route, "([0-9]+)") !== false) {
                foreach ($queries as $key => $query) {
                    $args[$query] = explode("/", $url)[$key];
                }
            }
            $controller = explode("@", $controller);
            $controller[0] = "App\\Controllers\\" . $controller[0];
            $controllerObj = new $controller[0]();
            if (count($args) > 0) {
                $controllerObj->{$controller[1]}(res: $this->response, args: $args);
                return true;
            }
            $controllerObj->{$controller[1]}(res: $this->response);
            return true;
        }
        return false;
    }
}