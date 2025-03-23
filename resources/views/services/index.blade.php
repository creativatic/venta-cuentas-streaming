@extends('layouts.app')
@section('title', 'Vista de Servicio')

@section('content')
<div class="container">
    <h1 class="mb-4">Servicios</h1>
    <a href="{{ route('services.create') }}" class="btn btn-primary mb-3">Nuevo Servicio</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio cuenta 
                    <br> Recomendado</th>
                <th>Precio perfil 
                    <br> Recomendado</th>
                <th>Perfiles</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($services as $service)
                <tr>
                    <td>{{ $service->id }}</td>
                    <td>{{ $service->name }}</td>
                    <td>${{ $service->price_services }}</td>
                    <td>${{ $service->individually_price_services }}</td>
                    <td>{{ $service->service_profiles }}</td>
                    <td>
                        @if($service->image)
                            <img src="{{ asset('storage/' . $service->image) }}" alt="Imagen" width="50">
                        @else
                            No disponible
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('services.show', $service) }}" class="btn btn-info btn-sm">Ver</a>
                        <a href="{{ route('services.edit', $service) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('services.destroy', $service) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar servicio?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection