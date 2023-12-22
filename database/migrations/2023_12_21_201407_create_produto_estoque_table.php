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
        Schema::create('PRODUTO_ESTOQUE', function (Blueprint $table) {
            $table->foreignId('PRODUTO_ID')->constrained('PRODUTO', 'PRODUTO_ID');
            $table->integer('PRODUTO_QTD');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('PRODUTO_ESTOQUE');
    }
};
