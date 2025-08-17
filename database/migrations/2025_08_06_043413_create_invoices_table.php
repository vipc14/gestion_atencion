    <?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void {
            Schema::create('invoices', function (Blueprint $table) {
                $table->id();
                $table->foreignId('customer_record_id')->constrained()->onDelete('cascade');
                $table->string('serial_usim')->nullable();
                $table->string('item_id')->nullable();
                $table->decimal('subtotal', 10, 2);
                $table->decimal('iva', 10, 2);
                $table->decimal('total_pagar', 10, 2);
                $table->string('recibido_por_pto');
                $table->string('metodo_pago');
                $table->string('numero_aprobacion');
                $table->timestamps();
            });
        }
        public function down(): void { Schema::dropIfExists('invoices'); }
    };
    
