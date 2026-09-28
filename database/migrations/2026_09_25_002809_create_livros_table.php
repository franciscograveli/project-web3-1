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
        Schema::create('livros', function (Blueprint $table) {
            $table->id();
            $table->char('titulo', 255)->nullable(false);
            $table->char('isbn', 45);
            $table->integer('anopublicacao');
            $table->char('descricao', 255)->nullable(false);
            $table->integer('paginas')->nullable(false);
            $table->foreignId('idAutor')->constrained('autores');
            $table->foreignId('idCategoria')->constrained('categorias');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livros');
    }
};
