@extends('layouts.app')
@section('title', 'Vista de Servicio show')

@section('content')
<div class="container">
    <h1>Detalle del Servicio</h1>

    <p><strong>Nombre:</strong> {{ $service->name }}</p>
    <p><strong>Precio:</strong> ${{ $service->price_services }}</p>
    <p><strong>Perfiles:</strong> {{ $service->service_profiles }}</p>
    <p><strong>Enlace:</strong> <a href="{{ $service->link }}" target="_blank">{{ $service->link }}</a></p>
    <p><strong>Descripción:</strong> {{ $service->description }}</p>

    @if($service->image)
        <p><strong>Imagen:</strong></p>
        <img class="rounded-circle header-profile-user" src="{{ asset('storage/' . $service->image) }}" alt="Imagen del Servicio" width="200">
    @endif

    <a href="{{ route('services.index') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection