<?php

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

//  Rota de status
Route::get('/', function() {
    return "Conectador!";
});

// Rota de getAll
Route::get("TodosColaboradores", [App\Http\Controllers\CollaboratorController::class, 'index']);
Route::get("TodosProdutos", [App\Http\Controllers\ProductController::class, 'indexProduct']);
Route::get("TodasCategorias", [App\Http\Controllers\ProductController::class, 'indexCategory']);
Route::get("TodasMarcas", [App\Http\Controllers\ProductController::class, 'indexMark']);

// Rota de getUnic
Route::get("Colaborador/{collaborator}", [App\Http\Controllers\CollaboratorController::class, 'collaborator']);
Route::get("Produto/{prodocut}", [App\Http\Controllers\ProductController::class, 'product']);
Route::get("Categoria/{prodocut}", [App\Http\Controllers\ProductController::class, 'category']);
Route::get("Marca/{prodocut}", [App\Http\Controllers\ProductController::class, 'mark']);

// Rota de cadastro
Route::post("CadastrarColaborador", [App\Http\Controllers\CollaboratorController::class, 'createCollaborator']);
Route::post("CadastrarProduto", [App\Http\Controllers\ProductController::class, 'createProduct']);
Route::post("CadastrarCategoria", [App\Http\Controllers\ProductController::class, 'createCategory']);
Route::post("CadastrarMarca", [App\Http\Controllers\ProductController::class, 'createMark']);

// Rota de login
Route::post("Logar", [App\Http\Controllers\LoginController::class, 'login']);

// Update password
Route::put("AtualizarSenha", [App\Http\Controllers\CollaboratorController::class, 'updatePassword']);

// Rota de atualizações
Route::put("AtualizarColaborador", [App\Http\Controllers\CollaboratorController::class, 'updateCollaborator']);
Route::put("AtualizarProduto", [App\Http\Controllers\ProductController::class, 'updateProduct']);
Route::put("AtualizarCategoria", [App\Http\Controllers\ProductController::class, 'updateCategory']);
Route::put("AtualizarMarca", [App\Http\Controllers\ProductController::class, 'updateMark']);

// Rota de delete
Route::post("DeletarColaborador", [App\Http\Controllers\CollaboratorController::class, 'deleteCollaborator']);
Route::post("DeletarProduto", [App\Http\Controllers\ProductController::class, 'deleteProduct']);
Route::post("DeletarCategoria", [App\Http\Controllers\ProductController::class, 'deleteCategory']);
Route::post("DeletarMarca", [App\Http\Controllers\ProductController::class, 'deleteMark']);
