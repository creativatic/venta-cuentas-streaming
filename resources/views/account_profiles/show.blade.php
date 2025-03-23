{{-- Esta vista está diseñada para ser cargada en un modal --}}
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Detalles del Perfil</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    
    <div class="modal-body">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-4"><strong>Nombre:</strong></div>
                    <div class="col-md-8">{{ $profile->profile_name }}</div>
                </div>
                
                <div class="row mb-2">
                    <div class="col-md-4"><strong>Número de Perfil:</strong></div>
                    <div class="col-md-8">{{ $profile->profile_number }}</div>
                </div>
                
                <div class="row mb-2">
                    <div class="col-md-4"><strong>PIN:</strong></div>
                    <div class="col-md-8">{{ $profile->profile_pin }}</div>
                </div>
                
                <div class="row mb-2">
                    <div class="col-md-4"><strong>Precio:</strong></div>
                    <div class="col-md-8">S/ {{ number_format($profile->price, 2) }}</div>
                </div>
               
                <div class="row mb-2">
                    <div class="col-md-4"><strong>Estado:</strong></div>
                    <div class="col-md-8">
                        <span class="badge bg-{{ $profile->status_profile == 'activo' ? 'success' : ($profile->status_profile == 'pendiente' ? 'warning' : 'danger') }}">
                            {{ ucfirst($profile->status_profile) }}
                        </span>
                    </div>
                </div>
                
                <div class="row mb-2">
                    <div class="col-md-4"><strong>Descripción:</strong></div>
                    <div class="col-md-8">{{ $profile->description ?: 'Sin descripción' }}</div>
                </div>
            </div>
        </div>
    </div>
    {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button> --}}

</div>