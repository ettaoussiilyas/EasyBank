<?php


    require_once '../app/config/db.php';
    require_once('../core/BaseController.php');
    require_once '../core/Router.php';
    require_once '../core/Route.php';
    require_once '../app/controllers/AuthController.php';
    require_once '../app/controllers/AdminController.php';
    require_once '../app/controllers/UserController.php';
    require_once '../app/controllers/AccountController.php';
    require_once '../app/controllers/TransferController.php';

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

    //Admin Routes
    $route::get('/admin', [AdminController::class, 'index']);
    $route::get('/admin/accounts', [AdminController::class, 'accounts']);
    $route::post('/admin/accounts/update', [AdminController::class, 'updateAccount']);
    $route::post('/admin/accounts/delete', [AdminController::class, 'deleteAccount']);
    $route::post('/admin/accounts/toggle-status', [AdminController::class, 'toggleStatus']);
    $route::get('/admin/accounts/search', [AdminController::class, 'searchAccounts']);
    $route::get('/admin/users/search', [AdminController::class, 'searchUsers']);
    $route::post('/admin/users/create', [AdminController::class, 'createUser']);
    $route::get('/admin/users', [AdminController::class, 'users']);
    $route::post('/admin/users/update', [AdminController::class, 'updateUser']);
    $route::post('/admin/users/delete', [AdminController::class, 'deleteUser']);
    $route::post('/admin/accounts/create', [AdminController::class, 'createAccount']);
    $route::get('/admin/reports', [AdminController::class, 'reports']);

    //user Routers
    Route::get('/user/profile', [UserController::class, 'profile']);
    Route::post('/user/profile', [UserController::class, 'updateProfile']);
    Route::get('/user/transactions', [UserController::class, 'transactions']);
    Route::get('/user/transfer', [UserController::class, 'transfer']);
    Route::get('/user/withdraw', [AccountController::class, 'showWithdraw']);
    Route::get('/user/deposit', [UserController::class, 'deposit']);
    Route::get('/user/account', [AccountController::class, 'showAccount']);

    Route::get('/user/deposit', [AccountController::class, 'showDeposit']);
    Route::post('/user/withdraw', [AccountController::class, 'withdrawChecker']);
    Route::post('/user/deposit', [AccountController::class, 'depositChecker']);


    //transfer routes
    Route::get('/user/transfer', [TransferController::class, 'showTransfer']);
   
    //logout 
    Route::get('/logout', [AuthController::class, 'logout']);


    $router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
