<?php

namespace App\Services\Pedidos;

use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Pizza;

interface RegraPrecoExtra
{
	public function calcularValorExtras(array $ingredientesExtras): float;
}

class PrecoExtraPadrao implements RegraPrecoExtra
{
	private float $precoPorIngrediente;

	public function __construct(float $precoPorIngrediente = 2.50)
	{
		$this->precoPorIngrediente = $precoPorIngrediente;
	}

	public function calcularValorExtras(array $ingredientesExtras): float
	{
		return count($ingredientesExtras) * $this->precoPorIngrediente;
	}
}

class CalculadoraPedido
{
	public function __construct(private RegraPrecoExtra $regraPrecoExtra = new PrecoExtraPadrao())
	{
	}

	public function calcularTotais(Pedido $pedido, array $itensPayload): void
	{
		$valorTotal = 0.0;

		foreach ($itensPayload as $payload) {
			$pizza = Pizza::findOrFail($payload['pizza_id']);
			$quantidade = (int) $payload['quantidade'];
			$extras = $payload['ingredientes_extras'] ?? [];

			$precoExtras = $this->regraPrecoExtra->calcularValorExtras($extras);
			$precoUnitario = (float) $pizza->preco_base;
			$precoTotalItem = ($precoUnitario + $precoExtras) * $quantidade;

			PedidoItem::create([
				'pedido_id' => $pedido->id,
				'pizza_id' => $pizza->id,
				'quantidade' => $quantidade,
				'ingredientes_extras' => $extras,
				'preco_unitario' => $precoUnitario,
				'preco_extras' => $precoExtras,
				'preco_total_item' => $precoTotalItem,
			]);

			$valorTotal += $precoTotalItem;
		}

		$pedido->valor_total = $valorTotal;
		$pedido->save();
	}
} 