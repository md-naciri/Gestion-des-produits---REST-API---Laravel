<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::group(['controller' => CategoryController::class], function () {
        Route::post('/categories', 'store')->middleware('permission:store category');
        Route::put('/categories/{id}', 'update')->middleware('permission:update category');
        Route::delete('/categories/{id}', 'destroy')->middleware('permission:delete category');
    });

    Route::group(['controller' => ProductController::class], function () {
        Route::post('/products', 'store')->middleware('permission:store product');
        Route::put('/products/{id}', 'update')->middleware('permission:update product|update every product');
        Route::delete('/products/{id}', 'destroy')->middleware('permission:delete my product|delete every product');
    });

    Route::put('/profile/{user}', [AuthenticationController::class, 'update']);

    Route::post('/assignRole/{id}', [RoleController::class, 'assignRole'])->middleware('permission:assign role');
    Route::post('/removeRole/{id}', [RoleController::class, 'removeRole'])->middleware('permission:assign role');

    Route::post('/assign-permission/{role}', [PermissionController::class, 'assignPermissionToRole'])->middleware('permission:assign permission');
    Route::delete('/remove-permission/{role}', [PermissionController::class, 'removePermissionFromRole'])->middleware('permission:assign permission');
});

Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);


Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/products/category/{categoryName}', [ProductController::class, 'getProductsByCategory']);

Route::group(['controller' => ResetPasswordController::class], function () {
    // Request password reset link
    Route::post('forgot-password', 'link')->middleware('guest')->name('password.email');
    // Reset password
    Route::post('reset-password', 'resetPassword')->middleware('guest')->name('password.update');

    Route::get('reset-password/{token}', function (string $token) {
        return $token;
    })->middleware('guest')->name('password.reset');
});
