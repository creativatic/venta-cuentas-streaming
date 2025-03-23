@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Asignar Roles a {{ $user->name }}</h2>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.users.roles.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Roles disponibles</label>
                            <div class="row">
                                @foreach($roles as $role)
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" id="role_{{ $role->id }}"
                                                {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="role_{{ $role->id }}">
                                                {{ $role->title }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mt-4">
                            <h5>Permisos asociados a los roles seleccionados:</h5>
                            <div class="permissions-preview mt-3">
                                <div id="permissions-list" class="mb-3">
                                    @foreach($user->roles->flatMap->permissions as $permission)
                                        <span class="badge bg-info me-1">{{ $permission->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar Roles</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleCheckboxes = document.querySelectorAll('input[name="roles[]"]');
        
        roleCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                updatePermissionsPreview();
            });
        });

        function updatePermissionsPreview() {
            // En una implementación real, esto se haría con una llamada AJAX para obtener
            // los permisos actualizados según los roles seleccionados
            // Este es solo un ejemplo simple para mostrar la funcionalidad
            
            const checkedRoles = Array.from(document.querySelectorAll('input[name="roles[]"]:checked'))
                .map(input => input.value);
            
            // La versión real haría una llamada a un endpoint que devuelve los permisos para los roles dados
            fetch(`{{ route('admin.users.get-permissions-for-roles') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ roles: checkedRoles })
            })
            .then(response => response.json())
            .then(data => {
                const permissionsList = document.getElementById('permissions-list');
                permissionsList.innerHTML = '';
                
                data.permissions.forEach(permission => {
                    const badge = document.createElement('span');
                    badge.classList.add('badge', 'bg-info', 'me-1');
                    badge.textContent = permission.title;
                    permissionsList.appendChild(badge);
                });
            })
            .catch(error => console.error('Error:', error));
        }
    });
</script>
@endpush
@endsection