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

    Route::prefix('fantasy-teams')->group(function () {
        Route::get('/', [FantasyTeamController::class, 'index']);
        Route::get('{fantasy_team}', [FantasyTeamController::class, 'show']);
        Route::post('/', [FantasyTeamController::class, 'store']);
        Route::put('{fantasy_team}', [FantasyTeamController::class, 'update']);
        Route::delete('{fantasy_team}', [FantasyTeamController::class, 'destroy'])->middleware('permission:delete_fantasy_team');
    });

    Route::prefix('players')->group(function () {
        Route::get('/', [PlayerController::class, 'index']);
        Route::get('{player}', [PlayerController::class, 'show']);
        Route::post('/', [PlayerController::class, 'store'])->middleware('permission:create_player');
        Route::put('{player}', [PlayerController::class, 'update'])->middleware('permission:edit_player');
        Route::delete('{player}', [PlayerController::class, 'destroy'])->middleware('permission:delete_player');
    });

    Route::prefix('teams')->group(function () {
        Route::get('/', [TeamController::class, 'index']);
        Route::get('{team}', [TeamController::class, 'show']);
        Route::post('/', [TeamController::class, 'store'])->middleware('permission:create_team');
        Route::put('{team}', [TeamController::class, 'update'])->middleware('permission:edit_team');
        Route::delete('{team}', [TeamController::class, 'destroy'])->middleware('permission:delete_team');
    });

    Route::prefix('divisions')->group(function () {
        Route::get('/', [DivisionController::class, 'index']);
        Route::get('{division}', [DivisionController::class, 'show']);
        Route::post('/', [DivisionController::class, 'store'])->middleware('permission:create_division');
        Route::put('{division}', [DivisionController::class, 'update'])->middleware('permission:edit_division');
        Route::delete('{division}', [DivisionController::class, 'destroy'])->middleware('permission:delete_division');
    });
});

require __DIR__.'/auth.php';
