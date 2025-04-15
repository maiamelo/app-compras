<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShoppingList extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'budget', // adicione o campo de orçamento
        'user_id', // se você estiver usando autenticação e relacionando a lista a um usuário
    ];

    // Relacionamento com itens (se houver)
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}