<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('pizzas', function (Blueprint $table) {
			$table->id();
			$table->string('nome');
			$table->text('ingredientes')->nullable();
			$table->enum('tamanho', ['pequena', 'media', 'grande']);
			$table->decimal('preco_base', 10, 2);
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('pizzas');
	}
}; 