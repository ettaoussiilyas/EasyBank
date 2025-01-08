<?php


    require_once '../app/config/db.php';
    require_once('../core/BaseController.php');
    require_once '../core/Router.php';
    require_once '../core/Route.php';
    require_once '../app/controllers/AuthController.php';
    require_once '../app/controllers/AdminController.php';


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
    //handling register
    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'registerChecker']);

    // Créer une instance de Route
    $route = new Route();

    //Auth Routes
    // Route::get('/register', [AuthController::class, 'showRegister']);
    $route::get('/admin', [AdminController::class, 'index']);
    $route::get('/admin/accounts', [AdminController::class, 'accounts']);
    $route::post('/admin/accounts/update', [AdminController::class, 'updateAccount']);
    $route::post('/admin/accounts/delete', [AdminController::class, 'deleteAccount']);
    $route::post('/admin/accounts/toggle-status', [AdminController::class, 'toggleStatus']);
    $route::get('/admin/accounts/search', [AdminController::class, 'searchAccounts']);
    $route::post('/admin/users/create', [AdminController::class, 'createUser']);
    $route::get('/admin/users', [AdminController::class, 'users']);
    $route::post('//admin/users/update', [AdminController::class, 'UpdatUser']);


    $router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
