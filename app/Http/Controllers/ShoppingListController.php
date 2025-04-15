<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ShoppingList;
use Illuminate\Http\Request;

class ShoppingListController extends Controller
{
    // exibir listas de compras
    public function index()
    {
        $shoppingLists = ShoppingList::with('items')->get(); // Pega todas as listas e seus itens
        return view('home', compact('shoppingLists')); // Retorna a view 'home.blade.php'
    }

    // exibir formulário para adicionar listas de compras
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'budget' => 'required|numeric|min:0',
        ]);


        ShoppingList::create($data);

        return redirect()->route('shopping_lists.index')->with('success', 'Lista criada com sucesso!');
    }

    // exibir formulário para adicionar itens
    public function storeItem(Request $request, $shoppingListId)
    {
        $shoppingList = ShoppingList::findOrFail($shoppingListId);

        $shoppingList->items()->create([
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity
        ]);

        return redirect()->route('shopping_lists.index');
    }

    // excluir listas de compras
    public function destroy(ShoppingList $shoppingList)
    {
        $shoppingList->delete();

        return redirect()->route('shopping_lists.index')->with('success', 'Lista excluída com sucesso!');
    }

    // excluir itens da lista de compras
    public function destroyItem(ShoppingList $shoppingList, Item $item)
    {
        $item->delete();

        return redirect()->route('shopping_lists.index')->with('success', 'Item excluído com sucesso!');
    }
}
