@extends('layouts.app')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-center mb-4">Minhas Listas de Compras</h1>

        <!-- Formulário para criar nova lista -->
        <form action="{{ route('shopping_lists.store') }}" method="POST">
            @csrf
            <div class="space-y-4 flex flex-col items-center justify-center">
                <input type="text" name="name" class="w-2/5 px-4 py-2 border border-gray-300 rounded-md"
                    placeholder="Nome da Lista" required>
                {{-- orçamento --}}
                <input type="number" name="budget" step="0.01" class="w-2/5 px-4 py-2 border border-gray-300 rounded-md"
                    placeholder="Orçamento (ex: 500.00)" required>
                <button type="submit" class="w-32 bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">Criar
                    Lista</button>
            </div>

        </form>

        <!-- Listar todas as listas -->
        <div class="mt-8">
            @foreach ($shoppingLists as $list)
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <h2 class="text-2xl font-semibold">{{ $list->name }}</h2>

                    <!-- Formulário para adicionar item na lista -->
                    <form action="{{ route('shopping_lists.store_item', $list->id) }}" method="POST" class="mt-4">
                        @csrf
                        <div class="space-y-1">
                            <input type="text" name="name" class="w-2/5 px-4 py-2 border border-gray-300 rounded-md"
                                placeholder="Nome do item" required>
                            <input type="number" name="price" class="w-1/6 px-4 py-2 border border-gray-300 rounded-md"
                                step="0.01" placeholder="Preço do item (R$)" required>
                            <input type="number" name="quantity" class="w-1/6 px-4 py-2 border border-gray-300 rounded-md"
                                value="1" min="1" placeholder="Quantidade" required>
                            <button type="submit"
                                class="w-32 bg-green-600 text-white py-2 rounded-md hover:bg-green-700">Adicionar +
                            </button>
                        </div>
                    </form>

                    <!-- Exibir itens da lista -->
                    <ul class="mt-4">
                        @foreach ($list->items as $item)
                            <li class="flex justify-between items-center bg-white p-2 mb-2 rounded-lg shadow-sm">
                                <span>{{ $item->name }} - R$ {{ number_format($item->price, 2, ',', '.') }} x
                                    {{ $item->quantity }} = R$ {{ number_format($item->total_price, 2, ',', '.') }}</span>
                                <form action="{{ route('shopping_lists.destroy_item', [$list->id, $item->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-600 text-white py-1 px-4 rounded-md hover:bg-red-700">Excluir</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>

                    <!-- Exibir total da lista -->
                    <h3 class="mt-4 text-xl font-semibold">
                        Total: R$
                        {{ number_format($list->items->sum(fn($item) => $item->total_price), 2, ',', '.') }}
                    </h3>
                    <!-- Exibir gráfico de porcentagem -->
                    @php
                        $orcamento = $list->budget;
                        $gasto = $list->items->sum(fn($item) => $item->total_price);
                        $porcentagem = ($gasto / $orcamento) * 100;
                    @endphp


                    <div class="mt-4">
                        <p class="mb-2 font-semibold">Orçamento: R$ {{ number_format($orcamento, 2, ',', '.') }}</p>

                        <div class="w-full h-6 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-300 
                                @if ($porcentagem < 70)
                                 bg-green-500
                                @elseif($porcentagem < 90)
                                bg-yellow-500
                                @else
                                bg-red-500 @endif"style="width: {{ min($porcentagem, 100) }}%;">
                            </div>
                        </div>

                        <p class="mt-1 text-sm text-gray-700">Gasto: R$ {{ number_format($gasto, 2, ',', '.') }}
                            ({{ number_format($porcentagem, 1) }}%)
                        </p>
                    </div>

                    <!-- Botão para excluir a lista -->
                    <form action="{{ route('shopping_lists.destroy', $list->id) }}" method="POST" class="mt-4">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-32 bg-red-600 text-white py-2 rounded-md hover:bg-red-700">Excluir
                            Lista</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
@endsection
