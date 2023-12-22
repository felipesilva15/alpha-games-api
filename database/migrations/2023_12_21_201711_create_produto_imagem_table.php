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
        Schema::create('PRODUTO_IMAGEM', function (Blueprint $table) {
            $table->id('IMAGEM_ID');
            $table->integer('IMAGEM_ORDEM');
            $table->foreignId('PRODUTO_ID')->constrained('PRODUTO', 'PRODUTO_ID');
            $table->string('IMAGEM_URL', 512);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('PRODUTO_IMAGEM');
    }
};
