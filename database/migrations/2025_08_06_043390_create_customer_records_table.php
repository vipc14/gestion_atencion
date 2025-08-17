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
        Schema::create('customer_records', function (Blueprint $table) {
            $table->id(); // Nº (auto incremental)
            $table->string('resultado')->nullable();
            $table->enum('prefijo', ['416', '426', '414', '424', '412', '422']);
            $table->string('contacto');
            $table->string('numero_contacto')->virtualAs('CONCAT(prefijo, contacto)'); // Combinación anidada

            $table->foreignId('attention_channel_id')->constrained();
            $table->foreignId('attention_queue_id')->constrained();
            $table->foreignId('attention_executive_id')->constrained();

            $table->date('fecha_atencion');
            $table->string('numero_contrato');
            $table->enum('prefijo_linea', ['416', '426']);
            $table->string('numero_linea');
            $table->string('numero_linea_gestionar')->virtualAs('CONCAT(prefijo_linea, numero_linea)'); // Combinación
            $table->enum('tecnologia', ['cdma', 'gsm', '3G', '4G', '5G']);


            $table->foreignId('line_type_id')->constrained();
            $table->foreignId('client_type_id')->constrained();
            $table->foreignId('segment_id')->constrained();


            $table->string('nombre_titular');
            $table->string('apellido_titular');
            $table->enum('nacionalidad', ['V', 'E']);
            $table->string('cedula_rif');
            $table->date('fecha_nacimiento');
            $table->enum('genero', ['M', 'F']);
            $table->boolean('atencion_preferencial')->default(false);
            $table->boolean('posee_discapacidad')->default(false);
            $table->boolean('adulto_mayor')->default(false); // Se calculará


           $table->foreignId('contact_reason_id')->constrained();
           $table->foreignId('reason_detail_id')->constrained();



            $table->boolean('es_titular')->default(true);
            $table->boolean('aprueba_id')->default(false);
            $table->boolean('dispone_saldo')->default(false);
            $table->string('numero_sim')->nullable();
            $table->string('email')->nullable();
            $table->text('observaciones')->nullable();
            $table->boolean('escalado')->default(false);
            $table->enum('estatus', ['Abierto', 'Cerrado'])->default('Abierto');
            $table->string('telefono_contacto_adicional')->nullable();
            $table->foreignId('estado_id')->constrained('states')->onDelete('cascade');
            $table->foreignId('ciudad_id')->constrained('cities')->onDelete('cascade');
            $table->foreignId('municipio_id')->constrained('municipalities')->onDelete('cascade');
            $table->foreignId('parroquia_id')->constrained('parishes')->onDelete('cascade');
            /*$table->string('tipo_direccion'); // Av, Cll, etc.*/
            $table->string('direccion');
            $table->string('punto_referencia')->nullable();
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_records');
    }
};
