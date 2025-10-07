<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Services\Pedidos\CalculadoraPedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
	public function index(Request $request)
	{
		$user = $request->user();
		$query = Pedido::with('itens.pizza');

		if ($user->role !== 'funcionario') {
			$query->where('user_id', $user->id);
		}

		return $query->orderByDesc('id')->paginate(10);
	}

	public function store(Request $request, CalculadoraPedido $calculadora)
	{
		$data = $request->validate([
			'itens' => 'required|array|min:1',
			'itens.*.pizza_id' => 'required|exists:pizzas,id',
			'itens.*.quantidade' => 'required|integer|min:1',
			'itens.*.ingredientes_extras' => 'array',
		]);

		return DB::transaction(function () use ($request, $calculadora, $data) {
			$pedido = Pedido::create([
				'user_id' => $request->user()->id,
				'status' => 'pendente',
				'valor_total' => 0,
			]);

			$calculadora->calcularTotais($pedido, $data['itens']);

			return response()->json($pedido->load('itens.pizza'), 201);
		});
	}

	public function show(Request $request, Pedido $pedido)
	{
		$this->authorizeOwnerOrFuncionario($request, $pedido);
		return $pedido->load('itens.pizza');
	}

	public function update(Request $request, Pedido $pedido, CalculadoraPedido $calculadora)
	{
		$this->authorizeOwnerOrFuncionario($request, $pedido);

		$data = $request->validate([
			'itens' => 'required|array|min:1',
			'itens.*.pizza_id' => 'required|exists:pizzas,id',
			'itens.*.quantidade' => 'required|integer|min:1',
			'itens.*.ingredientes_extras' => 'array',
			'status' => 'in:pendente,entregue,cancelado',
		]);

		return DB::transaction(function () use ($pedido, $calculadora, $data) {
			$pedido->itens()->delete();
			$calculadora->calcularTotais($pedido, $data['itens']);
			if (isset($data['status'])) {
				$pedido->status = $data['status'];
				$pedido->save();
			}
			return $pedido->load('itens.pizza');
		});
	}

	public function destroy(Request $request, Pedido $pedido)
	{
		$this->authorizeOwnerOrFuncionario($request, $pedido);
		$pedido->delete();
		return response()->json(['message' => 'Pedido removido']);
	}

	private function authorizeOwnerOrFuncionario(Request $request, Pedido $pedido): void
	{
		$user = $request->user();
		if ($user->role !== 'funcionario' && $pedido->user_id !== $user->id) {
			abort(403, 'Acesso negado');
		}
	}
}