<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LineType;
use App\Models\ClientType;
use App\Models\Segment;

class LineInfoSeeder extends Seeder
{
    public function run(): void
    {
        // Crear Tipos de Línea
        $prepago = LineType::create(['name' => 'Prepago']);
        $pospago = LineType::create(['name' => 'Pospago']);

        // --- Estructura para PREPAGO ---
        $prepago_natural = $prepago->clientTypes()->create(['name' => 'Natural']);
        $prepago_natural->segments()->create(['name' => 'N/A']);
        $prepago_natural->segments()->create(['name' => 'PYME']);

        $prepago_juridico = $prepago->clientTypes()->create(['name' => 'Juridico']);
        $prepago_juridico->segments()->create(['name' => 'PYME']);
        $prepago_juridico->segments()->create(['name' => 'Grandes Clientes']);

        // --- Estructura para POSPAGO ---
        $pospago_natural = $pospago->clientTypes()->create(['name' => 'Natural']);
        $pospago_natural->segments()->create(['name' => 'N/A']);
        $pospago_natural->segments()->create(['name' => 'PYME']);

        $pospago_juridico = $pospago->clientTypes()->create(['name' => 'Juridico']);
        $pospago_juridico->segments()->create(['name' => 'PYME']);
        $pospago_juridico->segments()->create(['name' => 'Grandes Clientes']);

        $pospago_excento = $pospago->clientTypes()->create(['name' => 'Excento']);
        $pospago_excento->segments()->create(['name' => 'N/A']);

        $pospago_empleado = $pospago->clientTypes()->create(['name' => 'Empleado']);
        $pospago_empleado->segments()->create(['name' => 'N/A']);
    }
}
