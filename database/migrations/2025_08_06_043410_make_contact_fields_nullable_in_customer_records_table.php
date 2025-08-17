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
        Schema::table('customer_records', function (Blueprint $table) {
            // Hacemos que las columnas permitan valores nulos.
            // El método change() modifica una columna existente.
            $table->string('prefijo')->nullable()->change();
            $table->string('contacto')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_records', function (Blueprint $table) {
            // Esto revierte los cambios si ejecutas un rollback.
            $table->string('prefijo')->nullable(false)->change();
            $table->string('contacto')->nullable(false)->change();
        });
    }
};
