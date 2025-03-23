<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Detalles del Cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $client->name_client }}</h5>
                <p class="card-text"><strong>Tipo:</strong> {{ $client->type_client }}</p>
                <p class="card-text"><strong>Teléfono:</strong> {{ $client->phone_client }}</p>
                <p class="card-text"><strong>Email:</strong> {{ $client->email_client ?? 'N/A' }}</p>
                <p class="card-text"><strong>Descripción:</strong> {{ $client->description ?? 'N/A' }}</p>
                <p class="card-text"><strong>Dirección:</strong> {{ $client->address ?? 'N/A' }}</p>
                <p class="card-text"><strong>Estado:</strong> {{ $client->status }}</p>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
    </div>
</div>