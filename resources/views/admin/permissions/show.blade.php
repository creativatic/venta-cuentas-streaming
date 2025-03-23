@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h4 class="card-title">Detalles del Permiso</h4>
                </div>
                <div class="col text-right">
                    <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Volver
                    </a>
                    <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="btn btn-primary">
                        <i class="fa fa-edit"></i> Editar
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">ID:</label>
                        <p>{{ $permission->id }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Título:</label>
                        <p>{{ $permission->title }}</p>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Fecha de Creación:</label>
                        <p>{{ $permission->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Última Actualización:</label>
                        <p>{{ $permission->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <h5>Roles con este Permiso</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Título</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($permission->roles as $role)
                                    <tr>
                                        <td>{{ $role->id }}</td>
                                        <td>{{ $role->title }}</td>
                                        <td>
                                            <a href="{{ route('admin.roles.show', $role->id) }}" class="btn btn-sm btn-info">
                                                <i class="fa fa-eye"></i> Ver Rol
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Este permiso no está asignado a ningún rol.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST" style="display: inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro que deseas eliminar este permiso?')">
                    <i class="fa fa-trash"></i> Eliminar Permiso
                </button>
            </form>
        </div>
    </div>
</div>
@endsection