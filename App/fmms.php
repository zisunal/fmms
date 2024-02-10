<?php
require_once __DIR__ . "/Core/App.php";
use App\Core\App;
$app = new App();

// Define routes here
$app->get("/", "HomeController@test");
$app->get("/themes", "AdminController@viewThemes");

$app->run();