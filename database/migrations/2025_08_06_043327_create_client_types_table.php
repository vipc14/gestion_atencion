<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_types', function (Blueprint $table) {
            $table->id();
            // Esta relación es polimórfica para que un tipo de cliente (ej. Natural) pueda pertenecer a varios tipos de línea.
            $table->morphs('typeable'); // Crea typeable_id y typeable_type
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_types');
    }
};
