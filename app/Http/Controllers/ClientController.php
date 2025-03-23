<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::all();
        $account = Account::first(); // O ajusta según la lógica de negocio
        return view('clients.index', compact('clients', 'account'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type_client' => 'required|string|max:50',
            'name_client' => 'required|string|max:255',
            'phone_client' => 'required|string|max:20',
            'email_client' => 'nullable|email|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'status' => 'nullable|string|max:50',
        ]);

        Client::create($request->all());

        return redirect()->route('clients.index')->with('success', 'Cliente creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function showModal($id)
    {
        try {
            $client = Client::findOrFail($id);
            return view('clients.show_modal', compact('client'));
        } catch (\Exception $e) {
            return '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
        }
    }

    public function editModal($id)
    {
        try {
            $client = Client::findOrFail($id);
            //dd($client); // 🔹 DETENER EJECUCIÓN PARA VER DATOS
            return view('clients.edit_modal', compact('client'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        try {
            $request->validate([
                'type_client' => 'required|string|max:50',
                'name_client' => 'required|string|max:255',
                'phone_client' => 'required|string|max:20',
                'email_client' => 'nullable|email|max:255',
                'description' => 'nullable|string',
                'address' => 'nullable|string',
                'status' => 'required|string|max:50',
            ]);

            $client->update($request->all());

            return response()->json(['success' => true, 'message' => 'Cliente actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Cliente eliminado exitosamente.');
    }

    public function createAccountModal($id)
    {
        try {
            // Recuperar la cuenta
            $account = Account::findOrFail($id);
            // Autorizar acceso a la creación de ventas de cuentas
            $this->authorize('create', Account::class);

            return view('clients.create_modal', compact('account'));
        } catch (\Exception $e) {
            return '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
        }
    }

}