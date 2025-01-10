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

// Auth Routes
Route::get('/', [AuthController::class, 'showHome']);
Route::get('/home', [AuthController::class, 'showHome']);
Route::get('', [AuthController::class, 'showHome']);
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'loginChecker']);
Route::get('/logout', [AuthController::class, 'logout']);

// Admin Routes
Route::get('/admin', [AdminController::class, 'index']);
Route::get('/admin/accounts', [AdminController::class, 'accounts']);
Route::post('/admin/accounts/update', [AdminController::class, 'updateAccount']);
Route::post('/admin/accounts/delete', [AdminController::class, 'deleteAccount']);
Route::post('/admin/accounts/toggle-status', [AdminController::class, 'toggleStatus']);
Route::get('/admin/accounts/search', [AdminController::class, 'searchAccounts']);
Route::get('/admin/users/search', [AdminController::class, 'searchUsers']);
Route::post('/admin/users/create', [AdminController::class, 'createUser']);
Route::get('/admin/users', [AdminController::class, 'users']);
Route::post('/admin/users/update', [AdminController::class, 'updateUser']);
Route::post('/admin/users/delete', [AdminController::class, 'deleteUser']);
Route::post('/admin/accounts/create', [AdminController::class, 'createAccount']);
Route::get('/admin/reports', [AdminController::class, 'reports']);

// User Routes
Route::get('/user/profile', [UserController::class, 'profile']);
Route::post('/user/profile', [UserController::class, 'updateProfile']);
Route::get('/user/transactions', [UserController::class, 'transactions']);
Route::get('/user/transfer', [TransferController::class, 'showTransfer']);
Route::get('/user/withdraw', [AccountController::class, 'showWithdraw']);
Route::get('/user/deposit', [AccountController::class, 'showDeposit']);
Route::get('/user/account', [AccountController::class, 'showAccount']);
Route::post('/user/withdraw', [AccountController::class, 'withdrawChecker']);
Route::post('/user/deposit', [AccountController::class, 'depositChecker']);

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
