<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContactReason;
use App\Models\ReasonDetail;

class ReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiar tablas para evitar duplicados en re-seeding
        ReasonDetail::query()->delete();
        ContactReason::query()->delete();

        $reasonsData = [
            'Consulta' => [
                'Consulta de Consumo y Beneficios', 'Consulta de línea (Pérdida)', 'Consulta de Saldo/Deuda/Estatus',
                'Estatus de Falla', 'Estatus de Reclamos', 'Estatus de Requerimiento', 'Info. De Canal Virtual',
                'Info. sobre cobros de Tecnología 4G', 'Info. sobre planes y promociones', 'Info. sobre servicios adicionales 4G',
                'Info. sobre servicios eSIM', 'Información de Migración', 'Información de Pago Pospago', 'Información Línea',
                'Métodos de Recarga Prepago', 'Información de Servicios LDI'
            ],
            'Falla Operativa' => [
                'Falla Recarga Bancaria', 'Falla en Actualización de Contadores', 'Falla Conexión de Líneas',
                'Falla Desconexión de Líneas', 'Falla de Datos y SMS', 'Falla de Recarga Patria',
                'Falla no Emite/ni Recibe Llamadas/SMS/Datos', 'Falla no Emite Llamadas', 'Falla no Emite Llamadas a Digitel',
                'Falla no Emite Llamadas a Movistar', 'Falla no Emite Llamadas ni SMS', 'Falla no Emite ni Recibe Llamadas',
                'Falla Sin Señal o Cobertura', 'Fallas Tarjeta SIM/USIM', 'Falla no Emite ni Recibe/SMS',
                'Falla no Emite ni Recibe Llamadas/SMS', 'Falla no Emite SMS', 'Falla no Emite SMS a Digitel',
                'Falla no Emite SMS a Movistar', 'Falla de Datos y Llamadas', 'Falla De Servicio Prepago',
                'Falla De Servicio Pospago', 'Falla no Recibe Llamadas', 'Falla no Recibe Llamadas/SMS',
                'Falla no Recibe Llamadas a Digitel', 'Falla no Recibe Llamadas a Movistar', 'Falla no Recibe SMS',
                'Falla Servicio de Datos 3G/4G/MAX DATOS', 'Falla NO Emite llamadas a CANTV', 'Falla no Recibe SMS a Digitel',
                'Falla no Recibe SMS a Movistar', 'Falla en Pago C2P Página', 'Falla Servicio eSIM', 'Falla de Servicios LDI'
            ],
            'Reclamo' => [
                'No Recibe Facturas', 'Cobro Errado de llamadas', 'Cobro Errado de Renta', 'Cobro Errados de SMS',
                'Cobro Errado de Tarifa', 'Cobro Errado de Datos', 'Cobro Excesivo MAX DATOS', 'Consumo de Saldo antes del Plan',
                'Pagos o Recarga no Aplicada', 'Insatisfacción del Servicio ATC', 'Renta No Disfrutada', 'Retraso en cobro de Renta',
                'Reclamo por línea pérdida', 'Recarga / Pago Errado', 'Pérdida de Saldo', 'Reclamos Servicios 4G',
                'Intento de fraude', 'Reclamo de Servicios LDI'
            ],
            'Requerimiento' => [
                'Desbloqueo por robo o Extravío', 'Actualización de correo Max Datos', 'Actualización de datos',
                'Actualización límite de crédito', 'Cambio de Número', 'Cambio de Plan y Servicios', 'Cambio de Serial Electrónico',
                'Desactivación de Servicios Especiales', 'Equipo mal programado', 'Reactivación Cooling S3',
                'Solicitud de Anulación de Línea', 'Solicitud de Cambio de plan Max Datos', 'Solicitud de Línea Adicional',
                'Solicitud de Migración POSPAGO', 'Suspensión por Extravío', 'Suspensión por Hurto', 'Suspensión por Robo',
                'Cambio de número', 'Suspensión Pospago', 'Cancelación de Línea Pospago', 'Activación de Servicios LDI'
            ],
            'Pagos' => ['Pago con Tarjeta de Debito', 'Recarga Prepago'],
            'Ventas' => [
                // Este array ahora contendrá objetos con nombre y costos
            ],
            'Otros Eventos' => [
                'No Procesado por Inconsistencia de Datos', 'Cambio de Plan no realizado', 'Fallas Operativas / Atención al cliente',
                'Requisitos Incompletos', 'FAOR USIM', 'Entrega de USIM PYME', 'Asistencia Recarga'
            ],
        ];

        // Datos de ventas con costos
        $salesData = [
            ['name' => 'Línea Nueva Pospago', 'costo_usim' => 25.86, 'gastos_admin' => 3.45, 'costo_contrato' => 3.45],
            ['name' => 'Línea Nueva Prepago', 'costo_usim' => 25.86, 'gastos_admin' => 3.45, 'costo_contrato' => 3.45],
            ['name' => 'Línea Nueva Empleado', 'costo_usim' => 25.86, 'gastos_admin' => 3.45, 'costo_contrato' => 3.45],
            ['name' => 'Activación eSIM Prepago', 'costo_usim' => 358.17, 'gastos_admin' => 3.45, 'costo_contrato' => 3.45],
            ['name' => 'Activación eSIM Pospago', 'costo_usim' => 25.86, 'gastos_admin' => 3.45, 'costo_contrato' => 3.45],
            ['name' => 'Act. Tecnológica Pospago', 'costo_usim' => 25.86, 'gastos_admin' => 3.45, 'costo_contrato' => 3.45],
            ['name' => 'Recuperación Pos USIM Cargo', 'costo_usim' => 25.86, 'gastos_admin' => 3.45, 'costo_contrato' => 3.45],
            ['name' => 'Recuperación Prepago', 'costo_usim' => 25.86, 'gastos_admin' => 3.45, 'costo_contrato' => 3.45],
            ['name' => 'Promo Vigente Linea Nueva Prepago', 'costo_usim' => 25.86, 'gastos_admin' => 3.45, 'costo_contrato' => 3.45],
            ['name' => 'Promo Vigente Linea Nueva Pospago', 'costo_usim' => 25.86, 'gastos_admin' => 3.45, 'costo_contrato' => 3.45],
            ['name' => 'Act. Tecnológica Prepago'],
            ['name' => 'FAOR USIM'],
            ['name' => 'Línea Nueva Prepago MAXDATOS'],
            ['name' => 'Línea Nueva Pospago MAXDATOS'],
        ];

        // Poblar las razones y detalles sin costos
        foreach ($reasonsData as $reasonName => $details) {
            if ($reasonName === 'Ventas') continue; // Saltamos Ventas para manejarlo por separado
            $reason = ContactReason::create(['name' => $reasonName]);
            foreach ($details as $detailName) {
                ReasonDetail::create([
                    'contact_reason_id' => $reason->id,
                    'name' => $detailName
                ]);
            }
        }

        // Poblar la razón de Ventas con sus detalles y costos
        $ventasReason = ContactReason::create(['name' => 'Ventas']);
        foreach ($salesData as $detail) {
            ReasonDetail::create([
                'contact_reason_id' => $ventasReason->id,
                'name' => $detail['name'],
                'costo_usim' => $detail['costo_usim'] ?? 0.00,
                'gastos_admin' => $detail['gastos_admin'] ?? 0.00,
                'costo_contrato' => $detail['costo_contrato'] ?? 0.00,
            ]);
        }
    }
}
