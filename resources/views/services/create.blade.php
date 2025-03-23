@extends('layouts.app')
@section('title', 'Crear Servicio')

@section('content')
<div class="container">
    <h1 class="mb-4">Crear Servicio</h1>

    <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="price_services" class="form-label">Precio cuenta</label>
            <input type="number" name="price_services" class="form-control" step="0.01" required>
        </div>

        <div class="mb-3">
            <label for="individually_price_services" class="form-label">Precio perfil</label>
            <input type="number" name="individually_price_services" class="form-control" step="0.01">
        </div>
        

        <div class="mb-3">
            <label for="service_profiles" class="form-label">Cantidad de Perfiles</label>
            <input type="number" name="service_profiles" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="link" class="form-label">Enlace (Opcional)</label>
            <input type="url" name="link" class="form-control">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Imagen</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('services.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection