<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminAuth;
use App\Http\Middleware\RoleAuth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// home
Route::get('/', [UserController::class, 'home']);

// search
Route::get('/search/{q}', [UserController::class, 'searchGame']);

// auth
Route::prefix('auth')->group(function(){
    
    Route::get('/login', [AuthController::class, 'showLoginPage'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterPage']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');

});

// game
Route::prefix('game')->group(function(){

    Route::get('/{id}', [GameController::class, 'gameDetails']);
    Route::post('/{id}', [GameController::class, 'addGameToCart'])->middleware('auth', 'roleAuth:2');
    Route::get('/adultOnly/{id}', [GameController::class, 'ShowCheckAge']);
    Route::post('/adultOnly/{id}', [GameController::class, 'checkAge']);
   
});

// admin
Route::prefix('admin')->group(function(){
  
    Route::get('/', [AdminController::class, 'manageGame'])->middleware('roleAuth:1'); // 1 is admin
    Route::get('/insertGame', [AdminController::class, 'showInsertForm'])->middleware('roleAuth:1');
    Route::post('/insertGame', [AdminController::class, 'insertGame']);
    
    Route::get('/deleteGame/{id}', [AdminController::class, 'showDeleteConfirmation'])->middleware('roleAuth:1');
    Route::post('/deleteGame/{id}', [AdminController::class, 'deleteGame']);
    
    Route::get('/updateGame/{id}', [AdminController::class, 'showUpdateForm'])->middleware('roleAuth:1');
    Route::post('/updateGame/{id}', [AdminController::class, 'updateGame']);

    Route::get('/searchGame', [AdminController::class, 'searchGame']);
});

// user
Route::prefix('user')->group(function(){
    
    Route::get('/cart', [MemberController::class, 'showCartPage'])->middleware('roleAuth:2'); // 2 is member
    
    Route::get('/cart/deleteItem/{id}', [MemberController::class, 'showDeleteConfirmation'])->middleware('roleAuth:2');
    Route::post('/cart/deleteItem/{id}', [MemberController::class, 'deleteCartItem'])->middleware('roleAuth:2');

    Route::get('/profile', [UserController::class, 'showProfile'])->middleware('auth', 'roleAuth:1,2');
    Route::post('/profile', [UserController::class, 'updateProfile']);

    Route::get('/friend', [UserController::class, 'showFriend'])->middleware('auth', 'roleAuth:2');
    Route::post('/friend', [UserController::class, 'addFriend']);
    Route::get('/friend/cancel/{id}', [UserController::class, 'cancelFriend'])->middleware('auth', 'roleAuth:2');
    Route::get('/friend/reject/{id}', [UserController::class, 'rejectFriend'])->middleware('auth', 'roleAuth:2');
    Route::get('/friend/accept/{id}', [UserController::class, 'acceptFriend'])->middleware('auth', 'roleAuth:2');

    Route::get('/history', [UserController::class, 'showHistoryPage'])->middleware('auth', 'roleAuth:2');

});

// transaction
Route::prefix('transaction')->group(function(){
    
    Route::get('/payment', [TransactionController::class, 'showPaymentPage'])->middleware('roleAuth:2');

    Route::get('/receipt', [TransactionController::class, 'showReceipt'])->middleware('roleAuth:2');
    Route::post('/receipt', [TransactionController::class, 'processPayment'])->middleware('roleAuth:2');
});