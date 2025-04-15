<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShoppingListController;

// Rota principal para exibir a lista de compras
Route::get('/', [ShoppingListController::class, 'index'])->name('home');
// Rotas para o CRUD de listas de compras
Route::resource('shopping_lists', ShoppingListController::class);
Route::post('shopping_lists/{shoppingList}/items', [ShoppingListController::class, 'storeItem'])->name('shopping_lists.store_item');

Route::delete('shopping_lists/{shoppingList}/items/{item}', [ShoppingListController::class, 'destroyItem'])->name('shopping_lists.destroy_item');