@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Empresa</h1>

    <form action="{{ route('companies.update', $company->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $company->name }}" required>
        </div>

        <div class="form-group">
            <label for="business_name">Razón Social</label>
            <input type="text" name="business_name" id="business_name" class="form-control" value="{{ $company->business_name }}" required>
        </div>

        <div class="form-group">
            <label for="tax_id">RUC</label>
            <input type="text" name="tax_id" id="tax_id" class="form-control" value="{{ $company->tax_id }}">
        </div>

        <div class="form-group">
            <label for="phone">Teléfono</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ $company->phone }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ $company->email }}" required>
        </div>

        <div class="form-group">
            <label for="address">Dirección</label>
            <input type="text" name="address" id="address" class="form-control" value="{{ $company->address }}" required>
        </div>

        <div class="form-group">
            <label for="currency">Tipo de moneda</label>
            <input type="text" name="currency" id="currency" class="form-control" value="{{ $company->currency }}" required>
        </div>

        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea name="description" id="description" class="form-control">{{ $company->description }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('companies.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection