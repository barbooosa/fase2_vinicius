<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('pedido_items', function (Blueprint $table) {
			$table->id();
			$table->foreignId('pedido_id')->constrained('pedidos')->onDelete('cascade');
			$table->foreignId('pizza_id')->constrained('pizzas');
			$table->unsignedInteger('quantidade');
			$table->json('ingredientes_extras')->nullable();
			$table->decimal('preco_unitario', 10, 2);
			$table->decimal('preco_extras', 10, 2)->default(0);
			$table->decimal('preco_total_item', 10, 2);
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('pedido_items');
	}
}; 