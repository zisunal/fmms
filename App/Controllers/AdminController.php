<?php
namespace App\Controllers;
use App\Core\Response;
/**
 * Admin controller
 * @package App\Controllers
 * @version 1.0.0
 * @since 1.0.0
 */
class AdminController {
    /**
     * View themes list
     * @param Response $res
     * @return void
     */
    public function viewThemes(Response $res) {
        $res->render("admin.themes");
    }
}