<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProductoController;
use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout',[AuthController::class,'logout']);// /api/logout

    // Almacenar Pedidos
    Route::apiResource('/pedidos',PedidoController::class);// api/categorias


    Route::apiResource('/categorias',CategoriaController::class);// api/categorias
    Route::apiResource('/productos',ProductoController::class);// api/productos
});

// Route::apiResource('/categorias',[CategoriaController::class,'index']);

// Autenticacion
Route::post('/registro',[AuthController::class,'register']); // /api/registro
Route::post('/login',[AuthController::class,'login']);// /api/login
