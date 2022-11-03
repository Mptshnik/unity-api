<?php

use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::post('register',[\App\Http\Controllers\UserController::class, 'create']);

Route::post('/anonymrecord', function (Request $request) {
    $record = new Record();
    $record->levels = $request->get('levels');
    $record->save();

    return response()->json([
        'message' => 'Рекорд добавлен!',
    ], 201);
});


Route::middleware('auth:api')->post('/record', function (Request $request) {
    $record = new Record();
    $record->levels = $request->get('levels');
    $record->user_id = \Auth::id();
    $record->save();

    return response()->json([
        'message' => 'Пользователь '. Auth::user()->getAuthIdentifierName().' добавил рекорд!',
    ], 201);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
