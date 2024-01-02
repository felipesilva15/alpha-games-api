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
        Schema::create('CARRINHO_ITEM', function (Blueprint $table) {
            $table->foreignId('USUARIO_ID')->constrained('USUARIO', 'USUARIO_ID');
            $table->foreignId('PRODUTO_ID')->constrained('PRODUTO', 'PRODUTO_ID');
            $table->integer('ITEM_QTD');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('CARRINHO_ITEM');
    }
};
