<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Registrar Cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    
    <div class="modal-body">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Información del Cliente</h5>

                <form action="{{ route('clients.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="type_client">Tipo de Cliente</label>
                        <input type="text" name="type_client" id="type_client" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="name_client">Nombre</label>
                        <input type="text" name="name_client" id="name_client" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="phone_client">Teléfono</label>
                        <input type="text" name="phone_client" id="phone_client" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="email_client">Email</label>
                        <input type="email" name="email_client" id="email_client" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="description">Descripción</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="address">Dirección</label>
                        <input type="text" name="address" id="address" class="form-control">
                    </div>

                    <div class="modal-footer mt-3">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>