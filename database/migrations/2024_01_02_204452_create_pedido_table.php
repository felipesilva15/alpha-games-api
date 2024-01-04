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
        Schema::create('PEDIDO', function (Blueprint $table) {
            $table->id('PEDIDO_ID');
            $table->foreignId('USUARIO_ID')->constrained('USUARIO', 'USUARIO_ID');
            $table->foreignId('ENDERECO_ID')->constrained('ENDERECO', 'ENDERECO_ID');
            $table->foreignId('STATUS_ID')->constrained('STATUS', 'STATUS_ID');
            $table->date('PEDIDO_DATA');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('PEDIDO');
    }
};
