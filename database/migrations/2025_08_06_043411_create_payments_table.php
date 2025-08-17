    <?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void {
            Schema::create('payments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('customer_record_id')->constrained()->onDelete('cascade');
                $table->foreignId('subscription_plan_id')->constrained();
                $table->string('cedula_depositante');
                $table->string('telefono_contacto');
                $table->string('id_transaccion');
                $table->decimal('total_pagar', 10, 2);
                $table->string('email');
                $table->string('recibido_por_pto'); // Mercantil, Venezuela
                $table->string('metodo_pago'); // Debito, Biopago
                $table->string('numero_aprobacion');
                $table->timestamps();
            });
        }
        public function down(): void { Schema::dropIfExists('payments'); }
    };
    