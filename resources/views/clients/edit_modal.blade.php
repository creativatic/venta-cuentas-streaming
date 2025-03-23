<div class="modal-content">
  
    <div class="modal-header">
        <h5 class="modal-title">Editar Cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    
    <div class="modal-body">

        @if(!isset($client))
            <div class="alert alert-danger">
                <strong>Error:</strong> No se pudo cargar la información del cliente.
            </div>
        @endif

        <form id="editClientForm" action="{{ route('clients.update', $client->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="type_client">Tipo de Cliente</label>
                <input type="text" name="type_client" id="type_client" class="form-control" value="{{ $client->type_client }}" required>
            </div>

            <div class="form-group">
                <label for="name_client">Nombre</label>
                <input type="text" name="name_client" id="name_client" class="form-control" value="{{ $client->name_client }}" required>
            </div>

            <div class="form-group">
                <label for="phone_client">Teléfono</label>
                <input type="text" name="phone_client" id="phone_client" class="form-control" value="{{ $client->phone_client }}" required>
            </div>

            <div class="form-group">
                <label for="email_client">Email</label>
                <input type="email" name="email_client" id="email_client" class="form-control" value="{{ $client->email_client }}">
            </div>

            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea name="description" id="description" class="form-control">{{ $client->description }}</textarea>
            </div>

            <div class="form-group">
                <label for="address">Dirección</label>
                <input type="text" name="address" id="address" class="form-control" value="{{ $client->address }}">
            </div>

            <!-- 🔹 Campo Estado del Perfil -->
            <div class="form-group">
                <label for="status">Estado del la cuenta</label>
                <select class="form-control" id="status" name="status">
                    <option value="activo" {{ $client->status == 'activo' ? 'selected' : '' }}>activo</option>
                    <option value="inactivo" {{ $client->status == 'inactivo' ? 'selected' : '' }}>inactivo</option>
                </select>
            </div>
            {{-- <div class="form-group">
                <label for="status">Estado del Cliente</label>
                <select class="form-control" id="status" name="status">
                    <option value="activo">ACTIVO</option>
                    <option value="inactivo">INACTIVO</option>
                </select>
            </div>     --}}
            
            <div class="modal-footer mt-3">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </form>
    </div>
</div>