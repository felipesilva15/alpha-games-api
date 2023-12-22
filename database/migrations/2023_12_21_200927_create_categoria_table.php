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
        Schema::create('CATEGORIA', function (Blueprint $table) {
            $table->id('CATEGORIA_ID');
            $table->string('CATEGORIA_NOME', 80);
            $table->string('CATEGORIA_DESC', 512);
            $table->boolean('CATEGORIA_ATIVO');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('CATEGORIA');
    }
};
