<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/certificate', function () {
    $data = Storage::get('certificate/pubkey-bri.pem');

    dd($data);
});

Route::post('/generate/token', [AuthController::class, 'token']);
Route::post('/generate/x-signature', [AuthController::class, 'xSignature']);
Route::post('/generate/oauth-signature', [AuthController::class, 'oAuthSignature']);

Route::post('/bank-statement', [BankController::class, 'statement']);
