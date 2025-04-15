<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    
    protected $fillable = ['name', 'price', 'quantity', 'shopping_list_id'];

    public function shoppingList()
    {
        return $this->belongsTo(ShoppingList::class);
    }

    // Método para calcular o valor total do item (quantidade * preço)
    public function getTotalPriceAttribute()
    {
        return $this->price * $this->quantity;
    }
}