<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('atendimentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pet_id');
            $table->unsignedBigInteger('servico_id');
            $table->unsignedBigInteger('veterinario_id');
            $table->dateTime('data');
            $table->decimal('preco_final', 10, 2);
            $table->enum('status', ['Agendado', 'Concluído', 'Cancelado'])->default('Agendado');
            $table->timestamps();

            $table->unique(['pet_id', 'servico_id', 'data']);
            $table->foreign('pet_id')->references('id')->on('pets');
            $table->foreign('servico_id')->references('id')->on('servicos');
            $table->foreign('veterinario_id')->references('id')->on('veterinarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atendimentos');
    }
};
