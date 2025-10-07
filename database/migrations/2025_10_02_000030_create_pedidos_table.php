<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('pedidos', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id')->constrained('users');
			$table->decimal('valor_total', 10, 2)->default(0);
			$table->enum('status', ['pendente', 'entregue', 'cancelado'])->default('pendente');
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('pedidos');
	}
}; 