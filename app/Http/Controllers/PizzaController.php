<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use Illuminate\Http\Request;

class PizzaController extends Controller
{
	public function index()
	{
		return Pizza::paginate(10);
	}

	public function store(Request $request)
	{
		$data = $request->validate([
			'nome' => 'required|string|max:255',
			'ingredientes' => 'nullable|string',
			'tamanho' => 'required|in:pequena,media,grande',
			'preco_base' => 'required|numeric|min:0',
		]);
		$pizza = Pizza::create($data);
		return response()->json($pizza, 201);
	}

	public function show(Pizza $pizza)
	{
		return $pizza;
	}

	public function update(Request $request, Pizza $pizza)
	{
		$data = $request->validate([
			'nome' => 'sometimes|required|string|max:255',
			'ingredientes' => 'nullable|string',
			'tamanho' => 'sometimes|required|in:pequena,media,grande',
			'preco_base' => 'sometimes|required|numeric|min:0',
		]);
		$pizza->update($data);
		return $pizza;
	}

	public function destroy(Pizza $pizza)
	{
		$pizza->delete();
		return response()->json(['message' => 'Pizza removida']);
	}
}
