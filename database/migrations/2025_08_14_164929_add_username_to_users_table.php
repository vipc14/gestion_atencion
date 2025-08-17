    <?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void {
            Schema::table('users', function (Blueprint $table) {
                // Añadimos la columna username, la hacemos única para el login
                $table->string('username')->unique()->after('name');
                // Hacemos que el email ya no sea único, puede haber usuarios sin email o repetidos
                $table->string('email')->nullable()->unique(false)->change();
            });
        }
        public function down(): void {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('username');
                $table->string('email')->unique()->change();
            });
        }
    };
    