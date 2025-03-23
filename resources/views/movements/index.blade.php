@extends('layouts.app')
@section('title', 'Vista de Movimientos')

@section('content')
<div class="container">
    <h1>Control de Movimientos</h1>

    <form method="GET" action="{{ route('movements.index') }}" class="mb-3">
        <div class="row">
            <input type="hidden" name="apply_filter" value="1">
            
            <div class="col-md-10">
                <input type="text" id="search" name="search" class="form-control" value="{{ request('search') }}" placeholder="Buscar por nombre de cliente o correo electrónico">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Buscar</button>
            </div>
        </div>
    </form>
    
    <!-- Resultados dinámicos -->
    <div id="search-results"></div>

    {{-- Tabla de Movimientos --}}
    {{-- Tabla de Movimientos --}}
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Clientes</th>
                    <th>Servicio</th>
                    <th>Estado de cuenta</th>
                    <th>Tipo de cuenta</th>
                    <th>Correo</th>
                    <th>Contraseña</th>
                    <th>.</th> <!-- Nueva columna para el botón del ojo -->
                    <th>Perfiles</th>
                    <th>Precio cuenta<i class="fas fa-chess-queen-alt    "></i></th>
                    <th>Precio Perfil</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($accounts as $account)
                    <tr>
                        <td>
                            @if ($account->clients->isNotEmpty())
                                @foreach ($account->clients as $client)
                                    {{ $client->name_client }}@if (!$loop->last), @endif
                                @endforeach
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $account->service->name ?? 'N/A' }}</td>
                        <td>
                            @if($account->status == 'activo' || $account->status == 'activo')
                                <span class="badge bg-success">{{ $account->status }}</span>
                            @elseif($account->status == 'pendiente' || $account->status == 'pendiente')
                                <span class="badge bg-warning text-dark">{{ $account->status }}</span>
                            @elseif($account->status == 'vencio' || $account->status == 'vencio')
                                <span class="badge bg-danger">{{ $account->status }}</span>
                            @elseif($account->status == 'suspendido' || $account->status == 'suspendido')
                                <span class="badge bg-dark">{{ $account->status }}</span>
                            @else
                                <span class="badge bg-secondary">{{ $account->status }}</span>
                            @endif
                        </td>
                        <td>{{ $account->type_account }}</td>
                        <td>{{ $account->email_account }}</td>
                        <td>
                            <span class="password-hidden">********</span>
                            <span class="password-visible d-none">{{ $account->pass_account }}</span>
                        </td> <!-- Solo se muestran los asteriscos aquí -->
                        <td>
                            <button class="btn btn-sm toggle-password" data-password="{{ $account->pass_account }}">
                                <i class="ri-eye-line text-primary"></i>
                            </button>
                        </td> <!-- Nueva columna con el botón de "ver contraseña" -->
                        <td>
                            @if($account->accountProfiles->isNotEmpty())
                                @foreach($account->accountProfiles as $profile)
                                    <i class="ri-shield-user-fill"
                                       style="color: 
                                            @if($profile->status_profile == 'activo') green; 
                                            @elseif($profile->status_profile == 'vencio') red; 
                                            @elseif($profile->status_profile == 'pendiente') yellow;
                                            @else black;
                                            @endif"
                                       data-id="{{ $profile->id }}"
                                       onclick="openProfileModal({{ $profile->id }})"
                                       data-bs-toggle="tooltip"
                                       data-bs-placement="top"
                                       title="Perfil: {{ $profile->profile_name }} | PIN: {{ $profile->profile_pin }}">
                                    </i>
                                @endforeach
                            @else
                                <span class="text-muted">Sin perfiles</span>
                            @endif
                        </td>
                        <td>S/ {{ number_format($account->price, 2) }}</td>
                        <td>S/ {{ number_format($profile->price, 2) }}</td>
                        <td>
                            <!-- C): -->
                            <a href="javascript:void(0)" onclick="openMovementModal({{ $account->id }})" class="btn btn-outline-info btn-sm">
                                <i class="ri-eye-line"></i> Ver detalles
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">No hay datos.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $accounts->links() }}
    </div>

    {{-- Botón para abrir el modal Vender cuenta createAccountSaleModal --}}
    <div class="d-flex justify-content-end mt-3">
        <button type="button" class="btn btn-success" onclick="openaccountSaleModal({{ $account->id }})">
            <i class="ri-add-circle-line"></i> Vender cuenta
        </button>
    </div>
  
    {{-- Modal para ver venta de cuentas (usando modalbootstrap) --}}
    <x-modalbootstrap id="createAccountSaleModal" size="modal-lg">
        <div id="accountSaleModalContent">
            <p class="text-center">Cargando...</p>
        </div>
    </x-modalbootstrap>
    
    {{-- Modal para ver detalles de movimiento (usando modalbootstrap) --}}
    <x-modalbootstrap id="viewMovementModal" size="modal-lg">
        <div id="movementModalContent">
            <p class="text-center">Cargando...</p>
        </div>
    </x-modalbootstrap>

    {{-- Modal para manejar perfiles segun color iconos (usando modalbootstrap) --}}
    <x-modalbootstrap id="profileModal" size="modal-lg">
        <div id="modalContent">
            <p class="text-center">Cargando...</p>
        </div>
    </x-modalbootstrap>
    
</div>



    {{-- Script para manejar la apertura del modal de detalles movements\view.blade.php --}}
    <script>
        function openMovementModal(accountId) {
            // Mostrar indicador de carga
            document.getElementById("movementModalContent").innerHTML = '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Cargando...</span></div><p>Cargando detalles...</p></div>';
            
            // Abrir el modal inmediatamente 
            var myModal = new bootstrap.Modal(document.getElementById('viewMovementModal'));
            myModal.show();
            
            // Construir la URL con el ID de la cuenta
            let url = "{{ route('movements.view', ':id') }}".replace(':id', accountId);
            
            // Realizar la petición AJAX
            fetch(url, { 
                headers: { 
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Respuesta del servidor: ' + response.status);
                }
                return response.text();
            })
            .then(html => {
                // Actualizar el contenido del modal con la respuesta
                document.getElementById("movementModalContent").innerHTML = html;
            })
            .catch(error => {
                console.error("Error cargando la vista:", error);
                document.getElementById("movementModalContent").innerHTML = `
                    <div class="alert alert-danger">
                        <h4>Error al cargar los detalles</h4>
                        <p>${error.message}</p>
                        <p>Intente nuevamente o contacte al administrador.</p>
                    </div>`;
            });
        }
    </script>

    {{-- Script para manejar la apertura del modal de venta de cuentas --}}
    <script>
        function openaccountSaleModal(accountId) {
        // Mostrar indicador de carga
            document.getElementById("accountSaleModalContent").innerHTML = `
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p>Cargando detalles...</p>
                </div>`;

            // Abrir el modal inmediatamente 
            var myModal = new bootstrap.Modal(document.getElementById('createAccountSaleModal'));
            myModal.show();

            // Construir la URL de la ruta con el ID de la cuenta
            let url = "{{ route('movements.create.modal', ['id' => '__ID__']) }}".replace('__ID__', accountId);

            // Realizar la petición AJAX para cargar la vista en el modal
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la solicitud: ' + response.status);
                }
                return response.text();
            })
            .then(html => {
                document.getElementById("accountSaleModalContent").innerHTML = html;
            })
            .catch(error => {
                console.error("Error cargando la vista:", error);
                document.getElementById("accountSaleModalContent").innerHTML = `
                    <div class="alert alert-danger">
                        <h4>Error al cargar los detalles</h4>
                        <p>${error.message}</p>
                        <p>Intente nuevamente o contacte al administrador.</p>
                    </div>`;
            });
        }
    </script>
    
    
    {{-- ver perfil segun color de icono --}}
    <script>
        function openProfileModal(profileId) {
            // Mostrar indicador de carga
            document.getElementById("modalContent").innerHTML = '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Cargando...</span></div><p>Cargando detalles del perfil...</p></div>';
            
            // Abrir el modal inmediatamente (mejor experiencia de usuario)
            var myModal = new bootstrap.Modal(document.getElementById('profileModal'));
            myModal.show();
            
            // Construir la URL con el ID del perfil
            let url = "{{ route('account_profiles.view', ':id') }}".replace(':id', profileId);
            
            // Realizar la petición AJAX
            fetch(url, { 
                headers: { 
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Respuesta del servidor: ' + response.status);
                }
                return response.text();
            })
            .then(html => {
                // Actualizar el contenido del modal con la respuesta
                document.getElementById("modalContent").innerHTML = html;
            })
            .catch(error => {
                console.error("Error cargando la vista:", error);
                document.getElementById("modalContent").innerHTML = `
                    <div class="alert alert-danger">
                        <h4>Error al cargar los detalles del perfil</h4>
                        <p>${error.message}</p>
                        <p>Intente nuevamente o contacte al administrador.</p>
                    </div>`;
            });
        }
    </script>

    {{-- visualización de contraseñas --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".toggle-password").forEach(button => {
                button.addEventListener("click", function() {
                    let row = this.closest("tr"); // Encuentra la fila más cercana
                    let spanHidden = row.querySelector(".password-hidden");
                    let spanVisible = row.querySelector(".password-visible");
                    let icon = this.querySelector("i");

                    if (spanHidden.classList.contains("d-none")) {
                        spanHidden.classList.remove("d-none");
                        spanVisible.classList.add("d-none");
                        icon.classList.replace("ri-eye-off-line", "ri-eye-line");
                    } else {
                        spanHidden.classList.add("d-none");
                        spanVisible.classList.remove("d-none");
                        icon.classList.replace("ri-eye-line", "ri-eye-off-line");
                    }
                });
            });
        });
    </script>

    {{-- visualiza tooltip con datos de name y pin de perfiles  --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>

    {{-- para la busqueda dinamica por correo y nombre  --}}
    <script>
    $(document).ready(function () {
        $('#search').on('keyup', function () {
            let query = $(this).val();
    
            if (query.length > 0) {
                $.ajax({
                    url: "{{ route('movements.search') }}",
                    type: "GET",
                    data: { search: query },
                    success: function (data) {
                        let resultsHtml = "<ul class='list-group mt-2'>";
                        if (data.length > 0) {
                            data.forEach(function (account) {
                                resultsHtml += `<li class="list-group-item">
                                    <strong>${account.email_account}</strong> - Cliente: ${account.clients?.name_client ?? 'N/A'}
                                </li>`;
                            });
                        } else {
                            resultsHtml += "<li class='list-group-item'>No se encontraron resultados.</li>";
                        }
                        resultsHtml += "</ul>";
                        $('#search-results').html(resultsHtml);
                    }
                });
            } else {
                $('#search-results').html('');
            }
        });
    });
    </script>


@endsection