<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\Zalo\ZaloController;
use App\Http\Controllers\Zalo\ZnsController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Mpos
Route::post('/invoices', [InvoiceController::class, 'addInvoice']);

Route::delete('/invoice-cancel', [InvoiceController::class, 'cancelInvoice']);

Route::put('/update-transaction', [InvoiceController::class, 'updateTransaction']);

Route::get('/get-invoice', [InvoiceController::class, 'getTransactionStatus']);


// Zalo
Route::get('/access-token', [ZaloController::class, 'accessToken']); // Done

Route::post('/access-token-by-refresh', [ZaloController::class, 'accessTokenByRefresh']); // Done

Route::get('/list-of-interested-customers', [ZaloController::class, 'getOfInterestedListCustomer']); // Done

Route::post('/send-message', [ZaloController::class, 'sendMessage']);

Route::post('/request-user-info', [ZaloController::class, 'requestUserInfo']); //Done

Route::post('/get-user-profile', [ZaloController::class, 'getUserProfile']); //Done

Route::post('/update-follower-info', [ZaloController::class, 'updateFollowerInfo']);

Route::get('/get-list-infomation-zalo', [ZaloController::class, 'getListInfomationZalo']);// Done

// Zns
Route::post('/send-zalo-message', [ZnsController::class, 'sendZaloMessage']); // Done