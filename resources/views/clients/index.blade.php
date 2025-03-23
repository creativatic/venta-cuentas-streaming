@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Lista de Clientes</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clients as $client)
                <tr>
                    <td>{{ $client->type_client }}</td>
                    <td>{{ $client->name_client }}</td>
                    <td>{{ $client->phone_client }}</td>
                    <td>{{ $client->email_client ?? 'N/A' }}</td>
                    <td>{{ $client->status }}</td>
                    <td>
                        <button type="button" class="btn btn-info btn-sm" onclick="openClientModal({{ $client->id }}, 'show')">Ver</button>
                        <button type="button" class="btn btn-warning btn-sm" onclick="openClientModal({{ $client->id }}, 'edit')">Editar</button>
                        <form action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este cliente?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    {{-- Botón para abrir el modal AGREGAR CLIENTE--}}
    <div class="d-flex justify-content-end mt-3">
        <button type="button" class="btn btn-success" onclick="opencreateAccountModal({{ $account->id }})">
            <i class="ri-add-circle-line"></i> Agregar cliente
        </button>
    </div>

    {{-- Modal para ver crear cliente (usando modalbootstrap) --}}
    <x-modalbootstrap id="createAccountModal" size="modal-lg">
        <div id="createAccountModalContent">
            <p class="text-center">Cargando...</p>
        </div>
    </x-modalbootstrap>

    <x-modalbootstrap id="clientShowModal" size="modal-lg">
        <div id="clientShowModalContent">
            <p class="text-center">Cargando...</p>
        </div>
    </x-modalbootstrap>
    
    <x-modalbootstrap id="clientEditModal" size="modal-lg">
        <div id="clientEditModalContent">
            <p class="text-center">Cargando...</p>
        </div>
    </x-modalbootstrap>

</div>

{{-- Script para manejar la apertura del modal de crear cliente --}}
<script>
    function opencreateAccountModal(accountId) {
    // Mostrar indicador de carga
        document.getElementById("createAccountModalContent").innerHTML = `
            <div class="text-center">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
                <p>Cargando detalles...</p>
            </div>`;

        // Abrir el modal inmediatamente 
        var myModal = new bootstrap.Modal(document.getElementById('createAccountModal'));
        myModal.show();

        // Construir la URL de la ruta con el ID de la cuenta
        let url = "{{ route('clients.create_modal', ['id' => '__ID__']) }}".replace('__ID__', accountId);

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
            document.getElementById("createAccountModalContent").innerHTML = html;
        })
        .catch(error => {
            console.error("Error cargando la vista:", error);
            document.getElementById("createAccountModalContent").innerHTML = `
                <div class="alert alert-danger">
                    <h4>Error al cargar los detalles</h4>
                    <p>${error.message}</p>
                    <p>Intente nuevamente o contacte al administrador.</p>
                </div>`;
        });
    }
</script>

<script>
    function openClientModal(clientId, type) {
        let modalId = type === 'show' ? 'clientShowModal' : 'clientEditModal';
        let contentId = type === 'show' ? 'clientShowModalContent' : 'clientEditModalContent';
        let route = type === 'show' ? 
            "{{ route('clients.show_modal', ['id' => '__ID__']) }}" : 
            "{{ route('clients.edit_modal', ['id' => '__ID__']) }}";

        let url = route.replace('__ID__', clientId);
        console.log("URL generada:", url); // 🔹 Verificar si la URL generada es correcta

        document.getElementById(contentId).innerHTML = `
            <div class="text-center">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
                <p>Cargando detalles...</p>
            </div>`;

        var myModal = new bootstrap.Modal(document.getElementById(modalId));
        myModal.show();

        fetch(url, { 
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' } 
        })
        .then(response => response.text())
        .then(html => {
            document.getElementById(contentId).innerHTML = html;
            
            // Si se trata del modal de edición, activamos el evento de submit con AJAX
            if (type === 'edit') {
                attachEditFormHandler();
            }
        })
        .catch(error => console.error("Error:", error));
    }

    function attachEditFormHandler() {
        let editForm = document.querySelector("#clientEditModal form");

        if (!editForm) {
            console.error("Formulario de edición no encontrado.");
            return;
        }

        editForm.addEventListener("submit", function (event) {
            event.preventDefault(); // Evita recargar la página

            let formData = new FormData(editForm);

            fetch(editForm.action, {
                method: "POST", // Laravel requiere POST para actualizar con AJAX
                body: formData,
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Cliente actualizado correctamente.");
                    location.reload(); // Recargar la tabla para ver los cambios
                } else {
                    alert("Error al actualizar el cliente: " + data.message);
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Ocurrió un error inesperado.");
            });
        }, { once: true }); // Se ejecuta solo una vez para evitar múltiples eventos
    }
</script>


@endsection