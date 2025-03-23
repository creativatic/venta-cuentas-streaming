@extends('layouts.app')

@section('content')
    <h1>Create New Account</h1>
    <form action="{{ route('accounts.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="user_id">User</label>
            <select name="user_id" id="user_id" class="form-control" required>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="services_id">Service</label>
            <select name="services_id" id="services_id" class="form-control" required onchange="updateServiceProfiles()">
                @foreach ($services as $service)
                    <option value="{{ $service->id }}" data-profiles="{{ $service->service_profiles }}">{{ $service->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="service_profiles">Total de perfiles</label>
            <input type="text" id="service_profiles" class="form-control" readonly>
            <input type="hidden" name="available_profiles" id="available_profiles">
            <input type="hidden" name="used_profiles" value="0">
        </div>
        <div class="form-group">
            <label for="name_account">Account Name</label>
            <input type="text" name="name_account" id="name_account" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email_account">Email</label>
            <input type="email" name="email_account" id="email_account" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="pass_account">Contraseña</label>
            <input type="password" name="pass_account" id="pass_account" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="type_account">Tipo de Cuenta</label>
            <select name="type_account" id="type_account" class="form-control" required>
                <option value="perfiles">perfiles</option>
                <option value="completa">completa</option>
            </select>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" step="0.01" name="price" id="price" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="date_pay">Date Pay</label>
            <input type="date" name="date_pay" id="date_pay" class="form-control" required value="{{ date('Y-m-d') }}">
        </div>
        <div class="form-group">
            <label for="renewal_date_account">Renewal Date</label>
            <input type="date" name="renewal_date_account" id="renewal_date_account" class="form-control" required value="{{ date('Y-m-d', strtotime('+30 days')) }}">
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="activo">activo</option>
                <option value="inactivo">pendiente</option>
                <option value="inactivo">vencio</option>
                <option value="inactivo">suspendido</option>
            </select>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Create Account</button>
    </form>

    <script>
        // Inicializar el campo de perfiles al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            updateServiceProfiles();
            
            // Actualizar fecha de renovación cuando cambia la fecha de pago
            document.getElementById('date_pay').addEventListener('change', function() {
                updateRenewalDate();
            });
        });

        // Función para actualizar el campo de perfiles según el servicio seleccionado
        function updateServiceProfiles() {
            const serviceSelect = document.getElementById('services_id');
            const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
            const profiles = selectedOption.getAttribute('data-profiles');
            
            document.getElementById('service_profiles').value = profiles;
            document.getElementById('available_profiles').value = profiles;
        }

        // Función para actualizar la fecha de renovación (30 días después de la fecha de pago)
        function updateRenewalDate() {
            const datePayInput = document.getElementById('date_pay');
            const datePay = new Date(datePayInput.value);
            
            if (datePay) {
                // Añadir 31 días a la fecha de pago
                const renewalDate = new Date(datePay);
                renewalDate.setDate(datePay.getDate() + 31);
                
                // Formatear la fecha al formato YYYY-MM-DD para el input date
                const year = renewalDate.getFullYear();
                const month = String(renewalDate.getMonth() + 1).padStart(2, '0');
                const day = String(renewalDate.getDate()).padStart(2, '0');
                
                document.getElementById('renewal_date_account').value = `${year}-${month}-${day}`;
            }
        }
    </script>
@endsection