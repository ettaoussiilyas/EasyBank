<?php

    require_once '../app/config/db.php';
    require_once ('../core/BaseController.php');
    require_once ('../app/controllers/AuthController.php');
    require_once '../core/Router.php';
    require_once '../core/Route.php';


    session_start();

    $router = new Router();
    Route::setRouter($router);

    //Auth Routes
    Route::get('/', [AuthController::class, 'showHome']);
    Route::get('/home', [AuthController::class, 'showHome']);
    Route::get('', [AuthController::class, 'showHome']);



    $router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

?>