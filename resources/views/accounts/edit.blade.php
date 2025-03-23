@extends('layouts.app') {{-- Asegúrate de que este layout exista --}}

@section('content')
<div class="container">
    <h1>Editar Cuenta</h1>
    <form action="{{ route('accounts.update', $account->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="user_id" class="form-label">Usuario</label>
            <select class="form-control" id="user_id" name="user_id" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $account->user_id == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="services_id" class="form-label">Servicio</label>
            <select class="form-control" id="services_id" name="services_id" required>
                @foreach($services as $service)
                    <option value="{{ $service->id }}" {{ $account->services_id == $service->id ? 'selected' : '' }}>
                        {{ $service->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="name_account" class="form-label">Nombre de la Cuenta</label>
            <input type="text" class="form-control" id="name_account" name="name_account" value="{{ $account->name_account }}" required>
        </div>

        <div class="mb-3">
            <label for="email_account" class="form-label">Email de la Cuenta</label>
            <input type="email" class="form-control" id="email_account" name="email_account" value="{{ $account->email_account }}" required>
        </div>

        <div class="mb-3">
            <label for="pass_account" class="form-label">Contraseña de la Cuenta</label>
            <input type="password" class="form-control" id="pass_account" name="pass_account" value="{{ $account->pass_account }}" required>
        </div>

        <div class="mb-3">
            <label for="type_account" class="form-label">Tipo de Cuenta</label>
            <input type="text" class="form-control" id="type_account" name="type_account" value="{{ $account->type_account }}" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Precio</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ $account->price }}" required>
        </div>

        <div class="mb-3">
            <label for="available_profiles" class="form-label">Perfiles Disponibles</label>
            <input type="number" class="form-control" id="available_profiles" name="available_profiles" value="{{ $account->available_profiles }}" required>
        </div>

        <div class="mb-3">
            <label for="used_profiles" class="form-label">Perfiles Usados</label>
            <input type="number" class="form-control" id="used_profiles" name="used_profiles" value="{{ $account->used_profiles }}" required>
        </div>

        <div class="mb-3">
            <label for="date_pay" class="form-label">Fecha de Pago</label>
            <input type="date" class="form-control" id="date_pay" name="date_pay" value="{{ $account->date_pay }}" required>
        </div>

        <div class="mb-3">
            <label for="renewal_date_account" class="form-label">Fecha de Renovación</label>
            <input type="date" class="form-control" id="renewal_date_account" name="renewal_date_account" value="{{ $account->renewal_date_account }}" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Estado</label>
            <select class="form-control" id="status" name="status" required>
                <option value="Activo" {{ $account->status == 'activo' ? 'selected' : '' }}>activo</option>
                <option value="Inactivo" {{ $account->status == 'pendiente' ? 'selected' : '' }}>pendiente</option>
                <option value="Suspendido" {{ $account->status == 'vencio' ? 'selected' : '' }}>vencio</option>
                <option value="Suspendido" {{ $account->status == 'suspendido' ? 'selected' : '' }}>suspendido</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" id="description" name="description">{{ $account->description }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Cuenta</button>
        <a href="{{ route('accounts.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection