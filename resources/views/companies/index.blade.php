@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Lista de Empresas</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Razón Social</th>
                <th>RUC</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Tipo de Moneda</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($companies as $company)
                <tr>
                    <td>{{ $company->name }}</td>
                    <td>{{ $company->business_name }}</td>
                    <td>{{ $company->tax_id ?? 'N/A' }}</td>
                    <td>{{ $company->phone }}</td>
                    <td>{{ $company->email }}</td>
                    <td>{{ $company->currency }}</td>
                    <td>
                        <a href="{{ route('companies.show', $company->id) }}" class="btn btn-info btn-sm">Ver</a>

                        {{-- Mostrar botón de edición solo si el usuario es Super Admin o es dueño de la empresa --}}
                        @if (auth()->user()->hasRole('Super Admin') || auth()->user()->company_id === $company->id)
                            <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        @endif

                        <form action="{{ route('companies.destroy', $company->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta empresa?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if (auth()->user()->hasRole('Super Admin'))
        <a href="{{ route('companies.create') }}" class="btn btn-primary">Crear Nueva Empresa</a>
    @endif
</div>
@endsection