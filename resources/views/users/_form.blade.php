@csrf
<div class="row g-3">
    <div class="col-md-6">
        <label for="name" class="form-label">Nombre y Apellido</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $usuario->name ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label for="username" class="form-label">Nombre de Usuario</label>
        <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $usuario->username ?? '') }}" required>
    </div>
    <div class="col-md-12">
        <label for="email" class="form-label">Correo Electrónico</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $usuario->email ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label for="password" class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="password" name="password" @if(!isset($usuario)) required @endif>
        @if(isset($usuario))<small class="form-text text-muted">Dejar en blanco para no cambiar la contraseña.</small>@endif
    </div>
    <div class="col-md-6">
        <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
    </div>
    <div class="col-md-12">
        <label for="role" class="form-label">Rol</label>
        <select id="role" name="role" class="form-select" required>
            <option value="">Seleccione un rol...</option>
            @foreach($roles as $role)
                <option value="{{ $role->name }}" @selected(old('role', isset($usuario) && $usuario->roles->isNotEmpty() ? $usuario->roles->first()->name : '') == $role->name)>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Contenedor condicional para Agentes -->
    <div class="col-md-12" id="agent-assignment-container" style="display: none;">
        <div class="row g-3 p-3 border rounded bg-light">
             <h5 class="mb-0">Asignación de Agente</h5>
            <div class="col-md-6">
                <label for="attention_channel_id" class="form-label">Canal de Atención</label>
                <select id="attention_channel_id" name="attention_channel_id" class="form-select">
                    <option value="">Seleccione un canal...</option>
                    @foreach($channels as $channel)
                        <option value="{{ $channel->id }}" @selected(old('attention_channel_id', $usuario->attentionExecutive?->attentionQueue?->attentionChannel?->id ?? '') == $channel->id)>
                            {{ $channel->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="attention_queue_id" class="form-label">Cola de Atención</label>
                <select id="attention_queue_id" name="attention_queue_id" class="form-select" disabled>
                    <option value="">Seleccione un canal primero...</option>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="col-12 mt-4 text-end">
    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> Guardar Usuario
    </button>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    function toggleAgentAssignment() {
        const selectedRole = $('#role').val();
        const container = $('#agent-assignment-container');
        const channelSelect = $('#attention_channel_id');
        const queueSelect = $('#attention_queue_id');

        if (selectedRole === 'usuario de acceso') {
            container.slideDown();
            channelSelect.prop('required', true);
            queueSelect.prop('required', true);
        } else {
            container.slideUp();
            channelSelect.prop('required', false).val('');
            queueSelect.prop('required', false).val('');
            resetDropdowns(['#attention_queue_id']);
        }
    }

    function resetDropdowns(selectors) {
        $.each(selectors, function(index, selector) {
            $(selector).empty().append('<option value="">Seleccione una opción</option>').prop('disabled', true);
        });
    }

    $('#attention_channel_id').change(function() {
        const channelId = $(this).val();
        const queueSelect = $('#attention_queue_id');
        resetDropdowns(['#attention_queue_id']);

        if (channelId) {
            $.get(`{{ url('/api/attention/queues') }}/${channelId}`, function(data) {
                queueSelect.empty().append('<option value="">Seleccione una cola...</option>');
                if (data && data.length > 0) {
                    $.each(data, function(key, value) {
                        queueSelect.append($('<option></option>').attr('value', value.id).text(value.name));
                    });
                    queueSelect.prop('disabled', false);
                }
            });
        }
    });

    // Lógica para pre-cargar en modo edición
    const initialChannelId = '{{ old('attention_channel_id', $usuario->attentionExecutive?->attentionQueue?->attentionChannel?->id ?? '') }}';
    if (initialChannelId) {
        $('#attention_channel_id').val(initialChannelId).trigger('change');
        setTimeout(function() {
            const initialQueueId = '{{ old('attention_queue_id', $usuario->attentionExecutive?->attention_queue_id ?? '') }}';
            if (initialQueueId) {
                $('#attention_queue_id').val(initialQueueId);
            }
        }, 600); // Dar tiempo a la llamada AJAX para poblar el dropdown
    }
    
    toggleAgentAssignment();
    $('#role').change(toggleAgentAssignment);
});
</script>
@endpush
