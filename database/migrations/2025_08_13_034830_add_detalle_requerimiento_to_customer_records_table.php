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
            // Añadimos la columna de tipo TEXT después de 'reason_detail_id'
            $table->text('detalle_requerimiento')->after('reason_detail_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_records', function (Blueprint $table) {
            // Esto permite revertir el cambio si es necesario
            $table->dropColumn('detalle_requerimiento');
        });
    }
};
