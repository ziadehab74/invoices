<?php

use App\Models\User;
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

Route::post('login-api', 'App\Http\Controllers\Api\Auth\LoginController@loginForm');
Route::post('get-user', function(Request $request){
    $userId = $request->user()->id;
    $user = User::find($userId);
    return $user;
})->middleware('auth:sanctum');
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
