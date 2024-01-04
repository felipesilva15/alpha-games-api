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
        Schema::create('PEDIDO_ITEM', function (Blueprint $table) {
            $table->foreignId('PRODUTO_ID')->constrained('PRODUTO', 'PRODUTO_ID');
            $table->foreignId('PEDIDO_ID')->constrained('PEDIDO', 'PEDIDO_ID');
            $table->integer('ITEM_QTD');
            $table->decimal('ITEM_PRECO', 5, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('PEDIDO_ITEM');
    }
};
