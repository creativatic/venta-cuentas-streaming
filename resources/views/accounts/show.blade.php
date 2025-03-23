@extends('layouts.app') {{-- Asegúrate de que este layout exista --}}

@section('content')
<div class="container">
    <h1>Detalles de la Cuenta</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $account->name_account }}</h5>
            <p class="card-text"><strong>Usuario:</strong> {{ $account->user->name }}</p>
            <p class="card-text"><strong>Servicio:</strong> {{ $account->service->name }}</p>
            <p class="card-text"><strong>Email:</strong> {{ $account->email_account }}</p>
            <p class="card-text"><strong>Tipo de Cuenta:</strong> {{ $account->type_account }}</p>
            <p class="card-text"><strong>Precio:</strong> ${{ number_format($account->price, 2) }}</p>
            <p class="card-text"><strong>Perfiles Disponibles:</strong> {{ $account->available_profiles }}</p>
            <p class="card-text"><strong>Perfiles Usados:</strong> {{ $account->used_profiles }}</p>
            <p class="card-text"><strong>Fecha de Pago:</strong> {{ $account->date_pay }}</p>
            <p class="card-text"><strong>Fecha de Renovación:</strong> {{ $account->renewal_date_account }}</p>
            <p class="card-text"><strong>Estado:</strong> {{ $account->status }}</p>
            <p class="card-text"><strong>Descripción:</strong> {{ $account->description ?? 'N/A' }}</p>
        </div>
    </div>
    <a href="{{ route('accounts.index') }}" class="btn btn-secondary mt-3">Volver</a>
</div>
@endsection