<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('especie');
            $table->string('raca')->nullable();
            $table->date('data_nasc');
            $table->boolean('sexo'); // M ou F
            $table->unsignedBigInteger('cliente_id');
            $table->boolean('status')->default(true); // true = ativo, false = inativo
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
