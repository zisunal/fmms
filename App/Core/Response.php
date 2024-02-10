<?php
namespace App\Core;
/**
 * Response class
 * @package App
 * @version 1.0.0
 * @since 1.0.0
 */
class Response {
    /**
     * Constructor
     */
    public function __construct() {
        ob_start();
    }
    /**
     * Send response
     * @param string $response
     * @return void
     */
    public function send(string $response) {
        echo $response;
    }
    public function render(string $zisunal_file, ...$args) : void {
        if (strpos($zisunal_file, ".zisunal.php") == false) {
            $engine = new ZisunalEngine();
            $engine->render($zisunal_file, ...$args);
        } else if (strpos($zisunal_file, ".php") !== false) {
            $args = array_map(function($arg) {
                return htmlspecialchars($arg);
            }, $args);
            $actual_file = str_replace(".", "/", $zisunal_file);
            $actual_file = __DIR__ . '/../../' . $actual_file;
            if (file_exists($actual_file)) {
                require_once $actual_file;
            } else {
                throw new \Exception("File not found: " . $actual_file);
            }
        } else {
            throw new \Exception("File format not supported: " . explode('.', $zisunal_file)[count(explode('.', $zisunal_file)) - 1]);
        }
    }
    /**
     * Redirect
     * @param string $url
     * @return void
     */
    public function redirect(string $url) {
        header("Location: " . $url);
    }
    /**
     * End response
     * @return void
     */
    public function end() {
        ob_end_flush();
    }
}