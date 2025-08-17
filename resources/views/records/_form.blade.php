@csrf
<div class="card">
    <div class="card-body">
        <!-- SECCIÓN 1: INFORMACIÓN DE ATENCIÓN -->
        <h4 class="mb-3 border-bottom pb-2">Información de Atención</h4>
        <div class="row g-3">
            <div class="col-md-4">
                <label for="fecha_atencion" class="form-label">Fecha de Atención</label>
                <input type="date" class="form-control" id="fecha_atencion" name="fecha_atencion" value="{{ old('fecha_atencion', $registro->fecha_atencion ?? date('Y-m-d')) }}" required>
            </div>
            <div class="col-md-4">
                <label for="attention_channel_id" class="form-label">Canal de Atención</label>
                <select id="attention_channel_id" name="attention_channel_id" class="form-select" required @if(isset($executive)) disabled @endif>
                    @if(isset($executive))
                        <option value="{{ $executive->attentionQueue->attentionChannel->id }}" selected>{{ $executive->attentionQueue->attentionChannel->name }}</option>
                    @else
                        <option value="">Seleccione un Canal</option>
                        @if(isset($channels))
                            @foreach($channels as $channel)
                                <option value="{{ $channel->id }}" data-name="{{ $channel->name }}" @selected(old('attention_channel_id', $registro->attention_channel_id ?? '') == $channel->id)>
                                    {{ $channel->name }}
                                </option>
                            @endforeach
                        @endif
                    @endif
                </select>
                @if(isset($executive))
                    <input type="hidden" name="attention_channel_id" value="{{ $executive->attentionQueue->attentionChannel->id }}">
                @endif
            </div>
            <div class="col-md-4">
                <label for="attention_queue_id" class="form-label">Cola de Atención</label>
                <select id="attention_queue_id" name="attention_queue_id" class="form-select" required @if(isset($executive)) disabled @endif>
                     @if(isset($executive))
                        <option value="{{ $executive->attentionQueue->id }}" selected>{{ $executive->attentionQueue->name }}</option>
                    @else
                        <option value="">Seleccione una Cola</option>
                    @endif
                </select>
                 @if(isset($executive))
                    <input type="hidden" name="attention_queue_id" value="{{ $executive->attentionQueue->id }}">
                @endif
            </div>
            <div class="col-md-6">
                <label for="attention_executive_id" class="form-label">Ejecutivo de Atención</label>
                <select id="attention_executive_id" name="attention_executive_id" class="form-select" required @if(isset($executive)) disabled @endif>
                    @if(isset($executive))
                        <option value="{{ $executive->id }}" selected>{{ $executive->name }}</option>
                    @else
                        <option value="">Seleccione un Ejecutivo</option>
                    @endif
                </select>
                @if(isset($executive))
                    <input type="hidden" name="attention_executive_id" value="{{ $executive->id }}">
                @endif
            </div>
            <!-- CAMPO NÚMERO DE CONTRATO (AHORA CONDICIONAL) -->
            <div class="col-md-6" id="numero-contrato-container" style="display: none;">
                <label for="numero_contrato" class="form-label">Número de Contrato</label>
                <input type="text" class="form-control" id="numero_contrato" name="numero_contrato" value="{{ old('numero_contrato', $registro->numero_contrato ?? '') }}">
            </div>
        </div>

        <!-- SECCIÓN 2: DATOS DEL TITULAR -->
        <h4 class="mt-4 mb-3 border-bottom pb-2">Datos del Titular</h4>
        <div class="row g-3">
            <div class="col-md-2">
                <label for="nacionalidad" class="form-label">Nacionalidad</label>
                <select id="nacionalidad" name="nacionalidad" class="form-select" required>
                    <option value="V" @selected(old('nacionalidad', $registro->nacionalidad ?? '') == 'V')>V</option>
                    <option value="E" @selected(old('nacionalidad', $registro->nacionalidad ?? '') == 'E')>E</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="cedula_rif" class="form-label">Nº Cédula o RIF</label>
                <input type="text" class="form-control" id="cedula_rif" name="cedula_rif" value="{{ old('cedula_rif', $registro->cedula_rif ?? '') }}" required>
            </div>
            <div class="col-md-6">
                <label for="nombre_titular" class="form-label">Nombres</label>
                <input type="text" class="form-control" id="nombre_titular" name="nombre_titular" value="{{ old('nombre_titular', $registro->nombre_titular ?? '') }}" required>
            </div>
            <div class="col-md-6">
                <label for="apellido_titular" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="apellido_titular" name="apellido_titular" value="{{ old('apellido_titular', $registro->apellido_titular ?? '') }}" required>
            </div>
            <div class="col-md-3">
                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                <div class="input-group">
                    <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $registro->fecha_nacimiento ? $registro->fecha_nacimiento->format('Y-m-d') : '') }}" required>
                    <span class="input-group-text" id="adulto-mayor-indicator" style="display: none;"><i class="fas fa-user-alt" title="Adulto Mayor"></i></span>
                </div>
            </div>
            <div class="col-md-3">
                <label for="genero" class="form-label">Género</label>
                <select id="genero" name="genero" class="form-select" required>
                    <option value="M" @selected(old('genero', $registro->genero ?? '') == 'M')>Masculino</option>
                    <option value="F" @selected(old('genero', $registro->genero ?? '') == 'F')>Femenino</option>
                </select>
            </div>
             <div class="col-md-6">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $registro->email ?? '') }}">
            </div>
        </div>

        <!-- SECCIÓN 3: DATOS DE LA LÍNEA Y CONTACTO -->
        <h4 class="mt-4 mb-3 border-bottom pb-2">Datos de la Línea y Contacto</h4>
        <div class="row g-3">
            <div class="col-md-4">
                <label for="line_type_id" class="form-label">Tipo de Línea</label>
                <select id="line_type_id" name="line_type_id" class="form-select" required>
                    <option value="">Seleccione un Tipo</option>
                    @if(isset($lineTypes)) @foreach($lineTypes as $type) <option value="{{ $type->id }}" @selected(old('line_type_id', $registro->line_type_id ?? '') == $type->id)>{{ $type->name }}</option> @endforeach @endif
                </select>
            </div>
            <div class="col-md-4">
                <label for="client_type_id" class="form-label">Tipo de Cliente</label>
                <select id="client_type_id" name="client_type_id" class="form-select" required disabled></select>
            </div>
            <div class="col-md-4">
                <label for="segment_id" class="form-label">Segmento</label>
                <select id="segment_id" name="segment_id" class="form-select" required disabled></select>
            </div>
            <div class="col-md-2">
                <label for="prefijo_linea" class="form-label">Prefijo Línea</label>
                <select id="prefijo_linea" name="prefijo_linea" class="form-select" required>
                    <option value="416" @selected(old('prefijo_linea', $registro->prefijo_linea ?? '') == '416')>416</option>
                    <option value="426" @selected(old('prefijo_linea', $registro->prefijo_linea ?? '') == '426')>426</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="numero_linea" class="form-label">Nº Línea</label>
                <input type="text" class="form-control" id="numero_linea" name="numero_linea" value="{{ old('numero_linea', $registro->numero_linea ?? '') }}" required>
            </div>
            <div class="col-md-6">
                <label for="tecnologia" class="form-label">Tecnología</label>
                <select id="tecnologia" name="tecnologia" class="form-select" required>
                    <option value="gsm" @selected(old('tecnologia', $registro->tecnologia ?? '') == 'gsm')>GSM</option>
                    <option value="3G" @selected(old('tecnologia', $registro->tecnologia ?? '') == '3G')>3G</option>
                    <option value="4G" @selected(old('tecnologia', $registro->tecnologia ?? '') == '4G')>4G</option>
                    <option value="5G" @selected(old('tecnologia', $registro->tecnologia ?? '') == '5G')>5G</option>
                    <option value="cdma" @selected(old('tecnologia', $registro->tecnologia ?? '') == 'cdma')>CDMA</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="numero_sim" class="form-label">Número de USIM</label>
                <input type="text" class="form-control" id="numero_sim" name="numero_sim" value="{{ old('numero_sim', $registro->numero_sim ?? '') }}">
            </div>
             <div class="col-md-6">
                <label for="telefono_contacto_adicional" class="form-label">Teléfono de Contacto Alternativo</label>
                <input type="text" class="form-control" id="telefono_contacto_adicional" name="telefono_contacto_adicional" value="{{ old('telefono_contacto_adicional', $registro->telefono_contacto_adicional ?? '') }}">
            </div>
        </div>

        <!-- SECCIÓN 4: DETALLE DEL REQUERIMIENTO -->
        <h4 class="mt-4 mb-3 border-bottom pb-2">Detalle del Requerimiento</h4>
        <div class="row g-3">
            <div class="col-md-6">
                <label for="contact_reason_id" class="form-label">Motivo del Contacto</label>
                <select id="contact_reason_id" name="contact_reason_id" class="form-select" required>
                    <option value="">Seleccione...</option>
                    @if(isset($reasons)) 
                        @foreach($reasons as $reason) 
                            <option value="{{ $reason->id }}" data-name="{{ $reason->name }}" @selected(old('contact_reason_id', $registro->contact_reason_id ?? '') == $reason->id)>
                                {{ $reason->name }}
                            </option> 
                        @endforeach 
                    @endif
                </select>
            </div>
            <div class="col-md-6">
                <label for="reason_detail_id" class="form-label">Detalle del Motivo</label>
                <select id="reason_detail_id" name="reason_detail_id" class="form-select" required disabled></select>
            </div>
            <div class="col-12">
                <label for="detalle_requerimiento" class="form-label">Observaciones del Requerimiento</label>
                <textarea class="form-control" id="detalle_requerimiento" name="detalle_requerimiento" rows="3" required>{{ old('detalle_requerimiento', $registro->detalle_requerimiento ?? '') }}</textarea>
            </div>
        </div>

        <!-- CONTENEDORES CONDICIONALES -->
        <div id="payments-container" class="mt-3" style="display: none;">
            <h4 class="mt-4 mb-3 border-bottom pb-2">Gestión de Pagos</h4>
            <div class="row g-3">
                <div class="col-md-4"><label for="payment_subscription_plan_id" class="form-label">Planes de Suscripción</label><select id="payment_subscription_plan_id" name="payment_subscription_plan_id" class="form-select"><option value="">Seleccione...</option>@if(isset($subscriptionPlans)) @foreach($subscriptionPlans as $plan) <option value="{{ $plan->id }}">{{ $plan->name }}</option> @endforeach @endif</select></div>
                <div class="col-md-4"><label for="payment_cedula_depositante" class="form-label">Cédula del Depositante</label><input type="text" id="payment_cedula_depositante" name="payment_cedula_depositante" class="form-control"></div>
                <div class="col-md-4"><label for="payment_telefono_contacto" class="form-label">Teléfono del Contacto</label><input type="text" id="payment_telefono_contacto" name="payment_telefono_contacto" class="form-control"></div>
                <div class="col-md-4"><label for="payment_id_transaccion" class="form-label">ID Transacción</label><input type="text" id="payment_id_transaccion" name="payment_id_transaccion" class="form-control"></div>
                <div class="col-md-4"><label for="payment_total_pagar" class="form-label">Total a Pagar</label><input type="number" step="0.01" id="payment_total_pagar" name="payment_total_pagar" class="form-control"></div>
                <div class="col-md-4"><label for="payment_email" class="form-label">Correo Electrónico</label><input type="email" id="payment_email" name="payment_email" class="form-control"></div>
                <div class="col-md-4"><label for="payment_recibido_por_pto" class="form-label">Recibido por PTO</label><select id="payment_recibido_por_pto" name="payment_recibido_por_pto" class="form-select"><option value="Mercantil">Mercantil</option><option value="Venezuela">Venezuela</option></select></div>
                <div class="col-md-4"><label for="payment_metodo_pago" class="form-label">Método de Pago</label><select id="payment_metodo_pago" name="payment_metodo_pago" class="form-select"><option value="Debito">Débito</option><option value="Biopago">Biopago</option></select></div>
                <div class="col-md-4"><label for="payment_numero_aprobacion" class="form-label">Número de Aprobación</label><input type="text" id="payment_numero_aprobacion" name="payment_numero_aprobacion" class="form-control"></div>
            </div>
        </div>
        <div id="recharges-container" class="mt-3" style="display: none;">
            <h4 class="mt-4 mb-3 border-bottom pb-2">Gestión de Recarga Prepago</h4>
            <div class="row g-3">
                <div class="col-md-4"><label for="recharge_numero_confirmacion_payall" class="form-label">Nº Confirmación PAYALL</label><input type="text" id="recharge_numero_confirmacion_payall" name="recharge_numero_confirmacion_payall" class="form-control"></div>
                <div class="col-md-4"><label for="recharge_numero_punto_venta" class="form-label">Nº Punto de Venta</label><input type="text" id="recharge_numero_punto_venta" name="recharge_numero_punto_venta" class="form-control"></div>
                <div class="col-md-4"><label for="recharge_total_recargar" class="form-label">Total a Recargar</label><input type="number" step="0.01" id="recharge_total_recargar" name="recharge_total_recargar" class="form-control"></div>
                <div class="col-md-4"><label for="recharge_recibido_por_pto" class="form-label">Recibido por PTO</label><select id="recharge_recibido_por_pto" name="recharge_recibido_por_pto" class="form-select"><option value="Mercantil">Mercantil</option><option value="Venezuela">Venezuela</option></select></div>
                <div class="col-md-4"><label for="recharge_metodo_pago" class="form-label">Método de Pago</label><select id="recharge_metodo_pago" name="recharge_metodo_pago" class="form-select"><option value="Debito">Débito</option><option value="Biopago">Biopago</option></select></div>
                <div class="col-md-4"><label for="recharge_numero_aprobacion" class="form-label">Nº de Aprobación</label><input type="text" id="recharge_numero_aprobacion" name="recharge_numero_aprobacion" class="form-control"></div>
            </div>
        </div>
        <div id="sales-container" class="mt-3" style="display: none;">
            <h4 class="mt-4 mb-3 border-bottom pb-2">Facturación de Venta</h4>
            <div class="row g-3">
                <div class="col-md-6"><label for="invoice_serial_usim" class="form-label">Serial USIM / ESIM</label><input type="text" id="invoice_serial_usim" name="invoice_serial_usim" class="form-control"></div>
                <div class="col-md-6"><label for="invoice_item_id" class="form-label">ID del Item</label><input type="text" id="invoice_item_id" name="invoice_item_id" class="form-control"></div>
            </div>
            <div class="row mt-4"><div class="col-md-7"><h5>Detalle de Cargos</h5><table class="table table-sm"><thead><tr><th>Concepto</th><th class="text-end">Costo S/IVA</th><th class="text-end">Total</th></tr></thead><tbody><tr><td>Costo USIM / ESIM</td><td class="text-end" id="costo-usim-siva">0.00</td><td class="text-end" id="costo-usim-total">0.00</td></tr><tr><td>Gastos Administrativos</td><td class="text-end" id="gastos-admin-siva">0.00</td><td class="text-end" id="gastos-admin-total">0.00</td></tr><tr><td>Costo Contrato</td><td class="text-end" id="costo-contrato-siva">0.00</td><td class="text-end" id="costo-contrato-total">0.00</td></tr><tr><td>Activación de Línea</td><td class="text-end" id="activacion-linea-siva">0.00</td><td class="text-end" id="activacion-linea-total">0.00</td></tr></tbody></table></div><div class="col-md-5"><h5>Resumen</h5><table class="table"><tbody><tr><td>Subtotal</td><td class="text-end" id="subtotal">0.00</td></tr><tr><td>IVA (16%)</td><td class="text-end" id="iva">0.00</td></tr><tr class="fw-bold"><td>TOTAL A PAGAR</td><td class="text-end fs-5" id="total-pagar">0.00</td></tr></tbody></table><h5>Información de Pago</h5><div class="row g-2"><div class="col-12"><label for="invoice_recibido_por_pto" class="form-label">Recibido por PTO</label><select id="invoice_recibido_por_pto" name="invoice_recibido_por_pto" class="form-select"><option value="Mercantil">Mercantil</option><option value="Venezuela">Venezuela</option></select></div><div class="col-12"><label for="invoice_metodo_pago" class="form-label">Método de Pago</label><select id="invoice_metodo_pago" name="invoice_metodo_pago" class="form-select"><option value="Debito">Débito</option><option value="Biopago">Biopago</option></select></div><div class="col-12"><label for="invoice_numero_aprobacion" class="form-label">Nº de Aprobación</label><input type="text" id="invoice_numero_aprobacion" name="invoice_numero_aprobacion" class="form-control"></div></div></div></div>
        </div>

        <!-- SECCIÓN 5: UBICACIÓN -->
        <h4 class="mt-4 mb-3 border-bottom pb-2">Ubicación</h4>
        <div class="row g-3">
            <div class="col-md-3"><label for="estado_id" class="form-label">Estado</label><select id="estado_id" name="estado_id" class="form-select" required><option value="">Seleccione...</option>@if(isset($states)) @foreach($states as $state) <option value="{{ $state->id }}" @selected(old('estado_id', $registro->estado_id ?? '') == $state->id)>{{ $state->name }}</option> @endforeach @endif</select></div>
            <div class="col-md-3"><label for="ciudad_id" class="form-label">Ciudad</label><select id="ciudad_id" name="ciudad_id" class="form-select" required disabled></select></div>
            <div class="col-md-3"><label for="municipio_id" class="form-label">Municipio</label><select id="municipio_id" name="municipio_id" class="form-select" required disabled></select></div>
            <div class="col-md-3"><label for="parroquia_id" class="form-label">Parroquia</label><select id="parroquia_id" name="parroquia_id" class="form-select" required disabled></select></div>
            <div class="col-md-12"><label for="direccion" class="form-label">Dirección</label><input type="text" class="form-control" id="direccion" name="direccion" value="{{ old('direccion', $registro->direccion ?? '') }}" required></div>
            <div class="col-12"><label for="punto_referencia" class="form-label">Punto de Referencia</label><input type="text" class="form-control" id="punto_referencia" name="punto_referencia" value="{{ old('punto_referencia', $registro->punto_referencia ?? '') }}"></div>
        </div>

        <!-- SECCIÓN 6: VALIDACIONES Y ESTATUS -->
        <h4 class="mt-4 mb-3 border-bottom pb-2">Validaciones y Estatus</h4>
        <div class="row g-3">
            <div class="col-md-3"><label for="estatus" class="form-label">Estatus</label><select id="estatus" name="estatus" class="form-select" required><option value="Abierto" @selected(old('estatus', $registro->estatus ?? 'Abierto') == 'Abierto')>Abierto</option><option value="Cerrado" @selected(old('estatus', $registro->estatus ?? '') == 'Cerrado')>Cerrado</option></select></div>
            <div class="col-md-9 d-flex align-items-center pt-4 flex-wrap">
                <div class="form-check form-switch me-3 mb-2"><input class="form-check-input" type="checkbox" id="es_titular" name="es_titular" value="1" @checked(old('es_titular', $registro->es_titular ?? true))><label class="form-check-label" for="es_titular">¿Es Titular?</label></div>
                <div class="form-check form-switch me-3 mb-2"><input class="form-check-input" type="checkbox" id="aprueba_id" name="aprueba_id" value="1" @checked(old('aprueba_id', $registro->aprueba_id ?? false))><label class="form-check-label" for="aprueba_id">¿Aprueba ID+?</label></div>
                <div class="form-check form-switch me-3 mb-2"><input class="form-check-input" type="checkbox" id="dispone_saldo" name="dispone_saldo" value="1" @checked(old('dispone_saldo', $registro->dispone_saldo ?? false))><label class="form-check-label" for="dispone_saldo">¿Dispone de Saldo?</label></div>
                <div class="form-check form-switch me-3 mb-2"><input class="form-check-input" type="checkbox" id="posee_discapacidad" name="posee_discapacidad" value="1" @checked(old('posee_discapacidad', $registro->posee_discapacidad ?? false))><label class="form-check-label" for="posee_discapacidad">¿Posee Discapacidad?</label></div>
                <div class="form-check form-switch me-3 mb-2"><input class="form-check-input" type="checkbox" id="atencion_preferencial" name="atencion_preferencial" value="1" @checked(old('atencion_preferencial', $registro->atencion_preferencial ?? false))><label class="form-check-label" for="atencion_preferencial">¿Requiere Atención Preferencial?</label></div>
                <div class="form-check form-switch mb-2"><input class="form-check-input" type="checkbox" id="escalado" name="escalado" value="1" @checked(old('escalado', $registro->escalado ?? false))><label class="form-check-label" for="escalado">¿Escalado?</label></div>
            </div>
        </div>
        <input type="hidden" name="es_titular" value="0"><input type="hidden" name="aprueba_id" value="0"><input type="hidden" name="dispone_saldo" value="0"><input type="hidden" name="posee_discapacidad" value="0"><input type="hidden" name="atencion_preferencial" value="0"><input type="hidden" name="escalado" value="0">

        <!-- BOTONES DE ACCIÓN -->
        <div class="col-12 mt-4 text-end">
            <a href="{{ route('registros.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Registro</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    const isAgent = $('#attention_executive_id').is(':disabled');
    
    function populateDropdown(selector, data, placeholder, selectedValue = null) {
        const dropdown = $(selector);
        dropdown.empty().append(`<option value="">${placeholder}</option>`);
        if (data && data.length > 0) {
            $.each(data, function(key, value) {
                const option = $('<option></option>').attr('value', value.id).text(value.name);
                if (value.id == selectedValue) { option.prop('selected', true); }
                dropdown.append(option);
            });
            dropdown.prop('disabled', false);
        } else {
            dropdown.prop('disabled', true);
        }
    }

    function resetDropdowns(selectors) {
        $.each(selectors, function(index, selector) {
            $(selector).empty().append('<option value="">Seleccione una opción</option>').prop('disabled', true);
        });
    }

    function checkSenior() {
        const birthDate = $('#fecha_nacimiento').val();
        if (!birthDate) { $('#adulto-mayor-indicator').hide(); return; }
        const age = new Date().getFullYear() - new Date(birthDate).getFullYear();
        if (age >= 60) { $('#adulto-mayor-indicator').show(); } 
        else { $('#adulto-mayor-indicator').hide(); }
    }

    function filterContactReasons() {
        const channelName = $('#attention_channel_id option:selected').text().trim();
        const contactReasonSelect = $('#contact_reason_id');
        const reasonsToHide = ['Pagos', 'Ventas'];

        if (channelName === 'Telefónica' || channelName === 'Virtual') {
            contactReasonSelect.find('option').each(function() {
                if (reasonsToHide.includes($(this).data('name'))) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
        } else {
            contactReasonSelect.find('option').show();
        }
        
        if (contactReasonSelect.find('option:selected').is(':hidden')) {
            contactReasonSelect.val('');
            resetDropdowns(['#reason_detail_id']);
        }
    }

    $('#fecha_nacimiento').on('change', checkSenior);
    checkSenior();

    if (!isAgent) {
        $('#attention_channel_id').change(function() {
            const channelId = $(this).val();
            filterContactReasons();
            resetDropdowns(['#attention_queue_id', '#attention_executive_id']);
            if (channelId) {
                $.get(`{{ url('/api/attention/queues') }}/${channelId}`, data => populateDropdown('#attention_queue_id', data, 'Seleccione una Cola'));
            }
        });

        $('#attention_queue_id').change(function() {
            const queueId = $(this).val();
            resetDropdowns(['#attention_executive_id']);
            if (queueId) {
                $.get(`{{ url('/api/attention/executives') }}/${queueId}`, data => populateDropdown('#attention_executive_id', data, 'Seleccione un Ejecutivo'));
            }
        });
    }

    filterContactReasons();

    function handleReasonChange() {
        const reasonName = $('#contact_reason_id option:selected').data('name');
        const detailName = $('#reason_detail_id option:selected').text().trim();
        const detailData = $('#reason_detail_id option:selected').data('costs');
        
        const contratoContainer = $('#numero-contrato-container');
        const contratoInput = $('#numero_contrato');

        if (reasonName === 'Ventas') {
            contratoContainer.slideDown();
            contratoInput.prop('required', true);
            if (contratoInput.val() === 'N/A') {
                contratoInput.val('');
            }
        } else {
            contratoContainer.slideUp();
            contratoInput.prop('required', false).val('N/A');
        }
        
        $('#payments-container, #recharges-container, #sales-container').hide();

        if (reasonName === 'Pagos') {
            if (detailName === 'Pago con Tarjeta de Debito') {
                $('#payments-container').slideDown();
            } else if (detailName === 'Recarga Prepago') {
                $('#recharges-container').slideDown();
            }
        } else if (reasonName === 'Ventas' && detailData) {
            $('#sales-container').slideDown();
            const ivaRate = 0.16;
            const costoUsim = parseFloat(detailData.costo_usim) || 0;
            const gastosAdmin = parseFloat(detailData.gastos_admin) || 0;
            const costoContrato = parseFloat(detailData.costo_contrato) || 0;
            const activacion = parseFloat(detailData.activacion_linea) || 0;
            const subtotal = costoUsim + gastosAdmin + costoContrato + activacion;
            const iva = subtotal * ivaRate;
            const total = subtotal + iva;
            $('#costo-usim-siva').text(costoUsim.toFixed(2));
            $('#gastos-admin-siva').text(gastosAdmin.toFixed(2));
            $('#costo-contrato-siva').text(costoContrato.toFixed(2));
            $('#activacion-linea-siva').text(activacion.toFixed(2));
            $('#costo-usim-total').text((costoUsim * (1 + ivaRate)).toFixed(2));
            $('#gastos-admin-total').text((gastosAdmin * (1 + ivaRate)).toFixed(2));
            $('#costo-contrato-total').text((costoContrato * (1 + ivaRate)).toFixed(2));
            $('#activacion-linea-total').text((activacion * (1 + ivaRate)).toFixed(2));
            $('#subtotal').text(subtotal.toFixed(2));
            $('#iva').text(iva.toFixed(2));
            $('#total-pagar').text(total.toFixed(2));
        }
    }

    $('#contact_reason_id').change(function() {
        const reasonId = $(this).val();
        resetDropdowns(['#reason_detail_id']);
        handleReasonChange();
        if (reasonId) {
            $.get(`{{ url('/api/reasons/details') }}/${reasonId}`, function(data) {
                const dropdown = $('#reason_detail_id');
                dropdown.empty().append(`<option value="">Seleccione un Detalle</option>`);
                if (data && data.length > 0) {
                    $.each(data, function(key, value) {
                        $('<option></option>').attr('value', value.id).text(value.name).data('costs', value).appendTo(dropdown);
                    });
                    dropdown.prop('disabled', false);
                }
            });
        }
    });
    $('#reason_detail_id').change(handleReasonChange);

    $('#line_type_id').change(function() {
        const lineTypeId = $(this).val();
        resetDropdowns(['#client_type_id', '#segment_id']);
        if (lineTypeId) {
            $.get(`{{ url('/api/line-info/client-types') }}/${lineTypeId}`, data => populateDropdown('#client_type_id', data, 'Seleccione un Tipo de Cliente'));
        }
    });

    $('#client_type_id').change(function() {
        const clientTypeId = $(this).val();
        resetDropdowns(['#segment_id']);
        if (clientTypeId) {
            $.get(`{{ url('/api/line-info/segments') }}/${clientTypeId}`, data => populateDropdown('#segment_id', data, 'Seleccione un Segmento'));
        }
    });

    $('#estado_id').change(function() {
        const stateId = $(this).val();
        resetDropdowns(['#ciudad_id', '#municipio_id', '#parroquia_id']);
        if (stateId) {
            $.get(`{{ url('/api/locations/cities') }}/${stateId}`, data => populateDropdown('#ciudad_id', data, 'Seleccione una Ciudad'));
        }
    });

    $('#ciudad_id').change(function() {
        const cityId = $(this).val();
        resetDropdowns(['#municipio_id', '#parroquia_id']);
        if (cityId) {
            $.get(`{{ url('/api/locations/municipalities') }}/${cityId}`, data => populateDropdown('#municipio_id', data, 'Seleccione un Municipio'));
        }
    });

    $('#municipio_id').change(function() {
        const municipalityId = $(this).val();
        resetDropdowns(['#parroquia_id']);
        if (municipalityId) {
            $.get(`{{ url('/api/locations/parishes') }}/${municipalityId}`, data => populateDropdown('#parroquia_id', data, 'Seleccione una Parroquia'));
        }
    });
});
</script>
@endpush