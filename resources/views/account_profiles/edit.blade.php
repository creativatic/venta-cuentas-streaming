<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Editar Perfil</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            
        </button>

    </div>
    
    <div class="modal-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form id="updateProfileForm" action="{{ route('account_profiles.update', $profile->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="profile_number">Número de Perfil</label>
                <input type="text" class="form-control" id="profile_number" name="profile_number" value="{{ $profile->profile_number ?? '' }}" readonly>
            </div>
            
            <div class="form-group">
                <label for="profile_name">Nombre del Perfil</label>
                <input type="text" class="form-control" id="profile_name" name="profile_name" value="{{ $profile->profile_name ?? '' }}">
            </div>
            
            <div class="form-group">
                <label for="profile_pin">PIN del Perfil</label>
                <input type="text" class="form-control" id="profile_pin" name="profile_pin" value="{{ $profile->profile_pin ?? '' }}">
            </div>
            
            <div class="form-group">
                <label for="price">Precio</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ $profile->price ?? '' }}" required>
            </div>
            
            <div class="form-group">
                <label for="status_profile">Estado del Perfil</label>
                <select class="form-control" id="status_profile" name="status_profile">
                    <option value="activo" {{ $profile->status_profile == 'activo' ? 'selected' : '' }}>activo</option>
                    <option value="pendiente" {{ $profile->status_profile == 'pendiente' ? 'selected' : '' }}>pendiente</option>
                    <option value="vencio" {{ $profile->status_profile == 'vencio' ? 'selected' : '' }}>vencio</option>
                    <option value="disponible" {{ $profile->status_profile == 'disponible' ? 'selected' : '' }}>disponible</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="accounts_id">ID de Cuenta</label>
                <input type="number" class="form-control" id="accounts_id" name="accounts_id" value="{{ $profile->accounts_id ?? '' }}" readonly>
                <small class="form-text text-muted">Este campo no se puede modificar</small>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>

        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#updateProfileForm').submit(function(e) {
        e.preventDefault();
        
        // Mostrar indicador de carga
        $('.modal-footer button[type="submit"]').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...');
        $('.modal-footer button').attr('disabled', true);
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                console.log('Éxito:', response);
                
                // Mostrar mensaje de éxito
                if (typeof toastr !== 'undefined') {
                    toastr.success(response.message || 'Perfil actualizado correctamente');
                } else {
                    alert(response.message || 'Perfil actualizado correctamente');
                }
                
                // Cerrar modal después de un breve retraso
                setTimeout(function() {
                    $('#modalContent').modal('hide');
                    
                    // Recargar la página o actualizar la vista
                    if (typeof refreshTable === 'function') {
                        refreshTable(); // Si tienes una función para refrescar tabla
                    } else {
                        window.location.reload(); // Alternativa: recargar página
                    }
                }, 1500);
            },
            error: function(xhr) {
                console.log('Error:', xhr);
                
                // Restaurar botón
                $('.modal-footer button[type="submit"]').html('Guardar Cambios');
                $('.modal-footer button').attr('disabled', false);
                
                // Mostrar mensaje de error
                var errorMsg = 'Error al actualizar el perfil';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                
                if (typeof toastr !== 'undefined') {
                    toastr.error(errorMsg);
                } else {
                    alert(errorMsg);
                }
            }
        });
    });
});
</script>