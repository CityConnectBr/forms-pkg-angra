<?php

use Mayrajp\Forms\Http\Controllers\Api\CompletedFormController;
use Mayrajp\Forms\Http\Controllers\Api\DynamicFormController;
use Mayrajp\Forms\Http\Controllers\Api\FieldController;
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

Route::apiResource('dynamic_forms', DynamicFormController::class);

Route::apiResource('field', FieldController::class);
Route::prefix('field')->controller(FieldController::class)->group(function () {
    Route::get('/all/by/form/{id}', 'getAllByForm');
});

Route::apiResource('completed_forms', CompletedFormController::class);
