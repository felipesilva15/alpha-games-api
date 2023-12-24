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
        Schema::create('ENDERECO', function (Blueprint $table) {
            $table->id('ENDERECO_ID');
            $table->string('ENDERECO_NOME', 40);
            $table->string('ENDERECO_LOGRADOURO', 140);
            $table->string('ENDERECO_NUMERO', 10);
            $table->string('ENDERECO_COMPLEMENTO', 80);
            $table->string('ENDERECO_CEP', 8);
            $table->string('ENDERECO_CIDADE', 20);
            $table->string('ENDERECO_ESTADO', 2);
            $table->foreignId('USUARIO_ID')->constrained('USUARIO', 'USUARIO_ID');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ENDERECO');
    }
};
