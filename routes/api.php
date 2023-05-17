<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\SoalController;

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

Route::get('posts', [PostController::class, 'index']);
Route::post('/posts/create', [App\Http\Controllers\Api\PostController::class, 'store']);
Route::get('/posts/{posts:slug}', [App\Http\Controllers\Api\PostController::class, 'show']);
// Route::get('/{id}', [MateriController::class, 'edit']);
Route::put('/posts/{id}/update', [App\Http\Controllers\Api\PostController::class, 'update']);
Route::delete('/posts/{id}/delete', [App\Http\Controllers\Api\PostController::class, 'destroy']);

Route::get('quests', [SoalController::class, 'index']);
Route::post('/quests/create', [SoalController::class, 'store']);
Route::get('/quests/{quests:kd}', [SoalController::class, 'show']);
Route::delete('/quests/{id}/delete', [SoalController::class, 'destroy']);

Route::post('code-glot', function (Request $request) {
    $input = $request->all();
    $response = Http::withHeaders([
        'Authorization' => env('GLOT_AUTH_TOKEN'),
        'Content-Type' => 'application/json'
    ])->post(env('GLOT_PYTHON_URL'), $input);
    return response()->json($response->json(), 200);
});

// Route::apiResource('/posts', App\Http\Controllers\Api\PostController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
