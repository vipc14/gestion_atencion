    <?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void {
            Schema::table('reason_details', function (Blueprint $table) {
                $table->decimal('costo_usim', 10, 2)->default(0.00);
                $table->decimal('gastos_admin', 10, 2)->default(0.00);
                $table->decimal('costo_contrato', 10, 2)->default(0.00);
                $table->decimal('activacion_linea', 10, 2)->default(0.00);
            });
        }
        public function down(): void {
            Schema::table('reason_details', function (Blueprint $table) {
                $table->dropColumn(['costo_usim', 'gastos_admin', 'costo_contrato', 'activacion_linea']);
            });
        }
    };
    