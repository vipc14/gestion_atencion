    <?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void {
            Schema::create('recharges', function (Blueprint $table) {
                $table->id();
                $table->foreignId('customer_record_id')->constrained()->onDelete('cascade');
                $table->string('numero_confirmacion_payall');
                $table->string('numero_punto_venta');
                $table->decimal('total_recargar', 10, 2);
                $table->string('recibido_por_pto');
                $table->string('metodo_pago');
                $table->string('numero_aprobacion');
                $table->timestamps();
            });
        }
        public function down(): void { Schema::dropIfExists('recharges'); }
    };
    