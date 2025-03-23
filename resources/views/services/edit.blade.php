@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Servicio</h1>

    <form action="{{ route('services.update', $service) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" name="name" class="form-control" value="{{ $service->name }}" required>
        </div>

        <div class="mb-3">
            <label for="price_services" class="form-label">Precio</label>
            <input type="number" name="price_services" class="form-control" step="0.01" value="{{ $service->price_services }}" required>
        </div>

        <div class="mb-3">
            <label for="service_profiles" class="form-label">Cantidad de Perfiles</label>
            <input type="number" name="service_profiles" class="form-control" value="{{ $service->service_profiles }}" required>
        </div>

        <div class="mb-3">
            <label for="link" class="form-label">Enlace (Opcional)</label>
            <input type="url" name="link" class="form-control" value="{{ $service->link }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea name="description" class="form-control">{{ $service->description }}</textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Imagen</label>
            <input type="file" name="image" class="form-control">
            @if($service->image)
                <img src="{{ asset('storage/' . $service->image) }}" alt="Imagen" width="100" class="mt-2">
            @endif
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('services.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection