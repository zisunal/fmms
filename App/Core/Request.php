<?php
namespace App\Core;
/**
 * Request class
 * @package App
 * @version 1.0.0
 * @since 1.0.0
 */
class Request {
    /**
     * @var array $queries
     */
    private $queries = [];
    /**
     * Constructor
     */
    public function __construct() {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $this->queries = $_POST;
        } else if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $this->queries = $_GET;
        }
    }
    /**
     * Get query
     * @param string $key
     * @return string
     */
    public function getQuery(string $key) {
        return $this->queries[$key];
    }
}