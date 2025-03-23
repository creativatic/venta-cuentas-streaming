@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h4 class="card-title">Editar Permiso</h4>
                </div>
                <div class="col text-right">
                    <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>
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
            
            <form action="{{ route('admin.permissions.update', $permission->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="title">Título del Permiso <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $permission->title) }}" required>
                    @error('title')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="roles">Asignar a Roles</label>
                    <select name="roles[]" id="roles" class="form-control select2 @error('roles') is-invalid @enderror" multiple>
                        @foreach($roles as $id => $title)
                            <option value="{{ $id }}" {{ (in_array($id, old('roles', [])) || $permission->roles->contains($id)) ? 'selected' : '' }}>{{ $title }}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Selecciona los roles a los que se asignará este permiso.</small>
                    @error('roles')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Actualizar Permiso
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
@endsection