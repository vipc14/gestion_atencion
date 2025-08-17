<?php
    namespace Database\Seeders;
    use Illuminate\Database\Seeder;
    use App\Models\SubscriptionPlan;

    class SubscriptionPlanSeeder extends Seeder {
        public function run(): void {
            $plans = [
                'MEGA PLUS 25', 'MEGA PLUS 12', 'MEGA PLUS 8', 'INNOVA 4.0 4GMAX', 'DONDE ESTAS 4G',
                'PUNTO DE VENTA INALAMBRICO GSM', 'TRACKER', 'MAXDATOS 250', 'MAXDATOS 100', 'MAXDATOS 50',
                'MAXDATOS 20', 'DATOS POR CONSUMO', 'PYME PLUS 25', 'PYME PLUS 12', 'PYME PLUS 6',
                'MP4 MADRES 2025', 'PLAN EMPLEADO 3.6', 'PLAN EMPLEADO 10', 'PLAN EMPLEADO 25',
                'PYME 12 Oficina Virtual', 'PYME 12 Redes Sociales', 'CONECTA FULL 5', 'CONECTA FULL 12',
                'CONECTA FULL 25', 'CONECTA FULL 50', 'CONECTA FULL 100', 'CONECTA FULL 250',
                'CREADORES DE CONTENIDO', 'ENTRETENIMIENTO', 'GAMERS', 'MENSAJERIA INSTANTANEA',
                'OFICINA VIRTUAL', 'REDES SOCIALES'
            ];
            foreach ($plans as $plan) {
                SubscriptionPlan::create(['name' => $plan]);
            }
        }
    }
    