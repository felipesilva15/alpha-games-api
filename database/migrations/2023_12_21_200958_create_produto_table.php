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
        Schema::create('PRODUTO', function (Blueprint $table) {
            $table->id('PRODUTO_ID');
            $table->string('PRODUTO_NOME', 200);
            $table->string('PRODUTO_DESC', 1024);
            $table->decimal('PRODUTO_PRECO', 5, 2);
            $table->decimal('PRODUTO_DESCONTO', 5, 2);
            $table->foreignId('CATEGORIA_ID')->constrained('CATEGORIA', 'CATEGORIA_ID');
            $table->boolean('PRODUTO_ATIVO');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('PRODUTO');
    }
};
