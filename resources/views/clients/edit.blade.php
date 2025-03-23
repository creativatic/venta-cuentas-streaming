@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Cliente</h1>

    <form action="{{ route('clients.update', $client->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="type_client">Tipo de Cliente</label>
            <input type="text" name="type_client" id="type_client" class="form-control" value="{{ $client->type_client }}" required>
        </div>

        <div class="form-group">
            <label for="name_client">Nombre</label>
            <input type="text" name="name_client" id="name_client" class="form-control" value="{{ $client->name_client }}" required>
        </div>

        <div class="form-group">
            <label for="phone_client">Teléfono</label>
            <input type="text" name="phone_client" id="phone_client" class="form-control" value="{{ $client->phone_client }}" required>
        </div>

        <div class="form-group">
            <label for="email_client">Email</label>
            <input type="email" name="email_client" id="email_client" class="form-control" value="{{ $client->email_client }}">
        </div>

        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea name="description" id="description" class="form-control">{{ $client->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="address">Dirección</label>
            <input type="text" name="address" id="address" class="form-control" value="{{ $client->address }}">
        </div>



        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('clients.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection