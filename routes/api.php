<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\OrganizationController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::post('organizations', [OrganizationController::class, 'store']);

    Route::post('organizations/{id}/invitations', [InvitationController::class, 'store']);
});

Route::get('invitations/{token}', [InvitationController::class, 'show']);
Route::post('invitations/{token}/accept', [InvitationController::class, 'accept']);

Route::get('/test-mail', function () {
    Mail::raw('Prueba Gmail', function ($msg) {
        $msg->to('dcartagenanavarro@gmail.com')
            ->subject('Test Gmail');
    });

    return 'enviado';
});
