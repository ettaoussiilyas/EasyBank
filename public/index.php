<?php


require_once '../app/config/db.php';
require_once('../core/BaseController.php');
require_once '../core/Router.php';
require_once '../core/Route.php';
require_once '../app/controllers/AuthController.php';
require_once '../app/controllers/AdminController.php';



$router = new Router();
Route::setRouter($router);

// Créer une instance de Route
$route = new Route();

//Auth Routes
// Route::get('/register', [AuthController::class, 'showRegister']);
$route::get('/admin', [AdminController::class, 'index']);



$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
