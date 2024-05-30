<?php

use App\Http\Controllers\DivisionController;
use App\Http\Controllers\FantasyTeamController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\TeamController;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('players', PlayerController::class);
    Route::apiResource('divisions', DivisionController::class);
    Route::apiResource('/fantasy-teams', FantasyTeamController::class);

    Route::prefix('teams')->group(function () {
        Route::get('/', [TeamController::class, 'index']);
        Route::get('{team}', [TeamController::class, 'show']);
        Route::post('/', [TeamController::class, 'store'])->middleware('permission:create_team');
        Route::put('{team}', [TeamController::class, 'update'])->middleware('permission:edit_team');
        Route::delete('{team}', [TeamController::class, 'destroy'])->middleware('permission:delete_team');
    });
});

require __DIR__.'/auth.php';
