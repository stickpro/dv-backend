<?php

use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\TransactionController;
use App\Http\Controllers\Api\Admin\WebhookController;
use App\Http\Controllers\Api\Root\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('admin')->name('admin.')->middleware(['auth:sanctum', 'admin.only'])->group(function () {
    Route::get('transactions/{txId}', [TransactionController::class, 'getTransactionInfo']);
    Route::post('transactions/{txId}/invoices/{invoice}', [TransactionController::class, 'attachTransactionToInvoice']);

    Route::post('invoices/{invoice}/webhook', [WebhookController::class, 'sendWebhook']);
});

Route::post('/admin/auth/login', [AuthController::class, 'login'])->middleware('guest');

Route::prefix('root')->name('root.')->middleware(['auth:sanctum', 'role:root'])->group(function () {
    Route::apiResource('users', UserController::class)->names('users');
});