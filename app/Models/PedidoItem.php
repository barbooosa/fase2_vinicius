<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoItem extends Model
{
	use HasFactory;

	protected $fillable = [
		'pedido_id', 'pizza_id', 'quantidade', 'ingredientes_extras', 'preco_unitario', 'preco_extras', 'preco_total_item',
	];

	protected $casts = [
		'ingredientes_extras' => 'array',
	];

	public function pedido()
	{
		return $this->belongsTo(Pedido::class);
	}

	public function pizza()
	{
		return $this->belongsTo(Pizza::class);
	}
} 