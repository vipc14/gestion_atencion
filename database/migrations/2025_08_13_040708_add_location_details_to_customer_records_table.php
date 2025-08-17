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
            // 1. Nos aseguramos de que la columna 'direccion' exista.
            if (!Schema::hasColumn('customer_records', 'direccion')) {
                $table->string('direccion')->after('parroquia_id');
            }

            // 2. Nos aseguramos de que la columna 'punto_referencia' exista.
            if (!Schema::hasColumn('customer_records', 'punto_referencia')) {
                $table->string('punto_referencia')->nullable()->after('direccion');
            }

            // 3. Eliminamos la columna 'tipo_direccion' si es que existe.
            if (Schema::hasColumn('customer_records', 'tipo_direccion')) {
                $table->dropColumn('tipo_direccion');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_records', function (Blueprint $table) {
            // Si hacemos rollback, restauramos la columna eliminada para coherencia.
            if (!Schema::hasColumn('customer_records', 'tipo_direccion')) {
                $table->string('tipo_direccion');
            }
        });
    }
};
