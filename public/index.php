<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

    require_once '../app/config/db.php';
    require_once ('../core/BaseController.php');
    require_once '../core/Router.php';
    require_once '../core/Route.php';



    $router = new Router();
    Route::setRouter($router);


    //Auth Routes
    // Route::get('/register', [AuthController::class, 'showRegister']);



    $router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

?>