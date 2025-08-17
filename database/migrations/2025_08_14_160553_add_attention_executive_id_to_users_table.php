    <?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void {
            Schema::table('users', function (Blueprint $table) {
                // Hacemos la columna nullable para que Administradores y Supervisores no necesiten estar asociados.
                $table->foreignId('attention_executive_id')->nullable()->constrained()->after('id');
            });
        }
        public function down(): void {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['attention_executive_id']);
                $table->dropColumn('attention_executive_id');
            });
        }
    };
    