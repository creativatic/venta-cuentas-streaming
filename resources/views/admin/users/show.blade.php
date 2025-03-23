@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Detalles del Usuario</h2>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label"><strong>Nombre:</strong></label>
                        <p>{{ $user->name }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><strong>Email:</strong></label>
                        <p>{{ $user->email }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><strong>Empresa:</strong></label>
                        <p>{{ $user->company->name ?? 'N/A' }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><strong>Roles:</strong></label>
                        <ul>
                            @foreach ($user->roles as $role)
                                <li>{{ $role->title }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Volver</a>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">Editar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection