@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalles de la Empresa</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $company->name }}</h5>
            <p class="card-text"><strong>Razón Social:</strong> {{ $company->business_name }}</p>
            <p class="card-text"><strong>RUC:</strong> {{ $company->tax_id ?? 'N/A' }}</p>
            <p class="card-text"><strong>Teléfono:</strong> {{ $company->phone }}</p>
            <p class="card-text"><strong>Email:</strong> {{ $company->email }}</p>
            <p class="card-text"><strong>Dirección:</strong> {{ $company->address }}</p>
            <p class="card-text"><strong>Tipo de moneda:</strong> {{ $company->currency }}</p>
            <p class="card-text"><strong>Descripción:</strong> {{ $company->description ?? 'N/A' }}</p>
        </div>
    </div>

    <div class="mt-3">
        {{-- Botón Volver: Redirige al dashboard si es Admin, o al listado de empresas si es Super Admin --}}
        @if (auth()->user()->hasRole('Super Admin'))
            <a href="{{ route('companies.index') }}" class="btn btn-secondary">Volver</a>
        @else
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Volver</a>
        @endif

        {{-- Mostrar botón de edición solo si el usuario es Super Admin --}}
        @if (auth()->user()->hasRole('Super Admin'))
            <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-warning">Editar</a>
        @endif
    </div>
</div>
@endsection