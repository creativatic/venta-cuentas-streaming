@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalles del Cliente</h1>

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

    <div class="mt-3">
        <a href="{{ route('clients.index') }}" class="btn btn-secondary">Volver</a>
        <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-warning">Editar</a>
    </div>
</div>
@endsection