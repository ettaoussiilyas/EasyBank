<?php


    require_once '../app/config/db.php';
    require_once('../core/BaseController.php');
    require_once '../core/Router.php';
    require_once '../core/Route.php';
    require_once '../app/controllers/AuthController.php';
    require_once '../app/controllers/AdminController.php';
    require_once '../app/controllers/UserController.php';


    session_start();

    $router = new Router();
    Route::setRouter($router);

    //Auth Routes
    //home handling
    Route::get('/', [AuthController::class, 'showHome']);
    Route::get('/home', [AuthController::class, 'showHome']);
    Route::get('', [AuthController::class, 'showHome']);
    //hadling login
    Route::get('/login', [AuthController::class, 'showLogin']);
    Route::post('/login', [AuthController::class, 'loginChecker']);


    // Créer une instance de Route
    $route = new Route();

    //Auth Routes
    // Route::get('/register', [AuthController::class, 'showRegister']);
    $route::get('/admin', [AdminController::class, 'index']);
    $route::get('/admin/accounts', [AdminController::class, 'accounts']);
    $route::post('/admin/accounts/update', [AdminController::class, 'updateAccount']);
    $route::post('/admin/accounts/delete', [AdminController::class, 'deleteAccount']);


    //user Routers
    Route::get('/user/profile', [UserController::class, 'profile']);
    Route::get('/user/account', [UserController::class, 'showAccount']);
    // Route::post('/user/profile', [UserController::class, 'updateProfile']);
    Route::get('/user/transactions', [UserController::class, 'transactions']);
    // Route::post('/user/transactions', [UserController::class, 'transactionChecker']);
    Route::get('/user/transfer', [UserController::class, 'transfer']);
    // Route::post('/user/transfer', [UserController::class, 'transferChecker']);
    Route::get('/user/withdraw', [UserController::class, 'withdraw']);
    // Route::post('/user/withdraw', [UserController::class, 'withdrawChecker']);
    Route::get('/user/deposit', [UserController::class, 'deposit']);
    // Route::post('/user/deposit', [UserController::class, 'depositChecker']);



    $router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
