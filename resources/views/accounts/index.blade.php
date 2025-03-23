@extends('layouts.app')

@section('content')
    <h1>Accounts</h1>
    <a href="{{ route('accounts.create') }}" class="btn btn-primary">Create New Account</a>
    <table class="table">
        <thead>
            <tr>
                <th>User</th>
                <th>Service</th>
                <th>Total perfiles</th>
                <th>Account Name</th>
                <th>Email</th>
                <th>Price</th>
                <th>Status</th>
                <th>Tipo de Cuenta</th>
                <th>Perfiles Disponibles</th>
                <th>Perfiles Usados</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($accounts as $account)
                <tr>
                    <td>{{ $account->user->name }}</td>
                    <td>{{ $account->service->name }}</td>
                    <td>{{ $account->service->service_profiles }}</td>
                    <td>{{ $account->name_account }}</td>
                    <td>{{ $account->email_account }}</td>
                    <td>${{ number_format($account->price, 2) }}</td>
                    <td>{{ $account->status }}</td>
                    <td>{{ $account->type_account }}</td>
                    <td>{{ $account->available_profiles }}</td>
                    <td>{{ $account->used_profiles }}</td>
                    <td>
                        <a href="{{ route('accounts.show', $account->id) }}" class="btn btn-info">Show</a>
                        <a href="{{ route('accounts.edit', $account->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('accounts.destroy', $account->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection