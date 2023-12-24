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
        Schema::create('USUARIO', function (Blueprint $table) {
            $table->id('USUARIO_ID');
            $table->string('USUARIO_NOME', 100);
            $table->string('USUARIO_EMAIL', 120);
            $table->string('USUARIO_SENHA', 80);
            $table->string('USUARIO_CPF', 11);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('USUARIO');
    }
};
