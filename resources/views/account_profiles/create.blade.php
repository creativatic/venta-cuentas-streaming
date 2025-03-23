
@section('content')
    <div class="container">
        <h1>Crear Perfil de Cuenta</h1>
        <form action="{{ route('account_profiles.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="profile_number">Número de Perfil</label>
                <input type="number" name="profile_number" id="profile_number" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="profile_name">Nombre de Perfil</label>
                <input type="text" name="profile_name" id="profile_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="price">Precio</label>
                <input type="text" name="price" id="price" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="accounts_id">Cuenta</label>
                <select name="accounts_id" id="accounts_id" class="form-control" required>
                    @foreach($accounts as $account)
                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Crear Perfil</button>
        </form>
    </div>
@endsection