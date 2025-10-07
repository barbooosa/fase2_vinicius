<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\PedidoController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
	Route::post('/logout', [AuthController::class, 'logout']);

	// Pizzas - somente funcionários em escrita
	Route::middleware('funcionario')->group(function () {
		Route::post('/pizzas', [PizzaController::class, 'store']);
		Route::put('/pizzas/{pizza}', [PizzaController::class, 'update']);
		Route::delete('/pizzas/{pizza}', [PizzaController::class, 'destroy']);
	});

	// Pedidos - cliente vê só seus, funcionário vê todos
	Route::get('/pedidos', [PedidoController::class, 'index']);
	Route::post('/pedidos', [PedidoController::class, 'store']);
	Route::get('/pedidos/{pedido}', [PedidoController::class, 'show']);
	Route::put('/pedidos/{pedido}', [PedidoController::class, 'update']);
	Route::delete('/pedidos/{pedido}', [PedidoController::class, 'destroy']);
});

// Leitura pública de pizzas (sem autenticar)
Route::get('/pizzas', [PizzaController::class, 'index']);
Route::get('/pizzas/{pizza}', [PizzaController::class, 'show']);