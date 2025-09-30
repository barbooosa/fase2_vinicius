<?php

use App\Http\Controllers\ClienteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('/cliente')->group(function () {
    Route::post('/cadastrar', [ClienteController::class, 'salvar']);
    Route::get('/listar', [ClienteController::class, 'listar']);
    Route::put('/atualizar/{id}', [ClienteController::class, 'atualizar']);
    Route::delete('/deletar/{id}', [ClienteController::class, 'deletar']);
});

Route::prefix('/pet')->group(function () {
    Route::post('/cadastrar', [ClienteController::class, 'salvar']);
    Route::get('/listar', [ClienteController::class, 'listar']);
    Route::put('/atualizar/{id}', [ClienteController::class, 'atualizar']);
    Route::delete('/deletar/{id}', [ClienteController::class, 'deletar']);
});


Route::prefix('/servico')->group(function () {
    Route::post('/cadastrar', [ClienteController::class, 'salvar']);
    Route::get('/listar', [ClienteController::class, 'listar']);
    Route::put('/atualizar/{id}', [ClienteController::class, 'atualizar']);
    Route::delete('/deletar/{id}', [ClienteController::class, 'deletar']);
});


Route::prefix('/veterinario')->group(function () {
    Route::post('/cadastrar', [ClienteController::class, 'salvar']);
    Route::get('/listar', [ClienteController::class, 'listar']);
    Route::put('/atualizar/{id}', [ClienteController::class, 'atualizar']);
    Route::delete('/deletar/{id}', [ClienteController::class, 'deletar']);
});


Route::prefix('/atendimento')->group(function () {
    Route::post('/cadastrar', [ClienteController::class, 'salvar']);
    Route::get('/listar', [ClienteController::class, 'listar']);
    Route::put('/atualizar/{id}', [ClienteController::class, 'atualizar']);
    Route::delete('/deletar/{id}', [ClienteController::class, 'deletar']);
});