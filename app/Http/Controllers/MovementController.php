<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Client;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class MovementController extends Controller
{
    
    public function index(Request $request)
    {
        // Autorizar acceso a la lista de cuentas
        $this->authorize('viewAny', Account::class);

        $query = Account::with(['clients', 'service']);

        // Solo aplicamos el filtro si el usuario presiona el botón
        if ($request->has('apply_filter')) {
            $searchTerm = $request->input('search');

            if ($searchTerm) {
                $query->where(function($q) use ($searchTerm) {
                    // Buscar por correo electrónico
                    $q->where('email_account', 'LIKE', '%' . $searchTerm . '%')
                    // O buscar por nombre de cliente
                    ->orWhereHas('clients', function($subq) use ($searchTerm) {
                        $subq->where('name_client', 'LIKE', '%' . $searchTerm . '%');
                    });
                });
            }
        }

        // Si se proporciona un ID específico de cuenta
        if ($request->has('account_id')) {
            $query->where('id', $request->input('account_id'));
        }

        // Ahora usamos la query que construimos
        $accounts = $query->paginate(10);

        // Obtener todos los clientes y servicios para el formulario
        $clients = Client::all();
        $services = Service::all();

        return view('movements.index', compact('accounts', 'clients', 'services'));
    }

    public function show($id)
    {
        $account = Account::with(['clients', 'service'])->findOrFail($id);
        // Autorizar policies acceso a los detalles de la cuenta
        $this->authorize('view', $account);
        return view('movements.show', compact('account'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'service_id' => 'required|exists:services,id',
            'price' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        // Guardamos el movimiento en Account, si corresponde
        Account::create([
            'client_id' => $request->client_id,
            'service_id' => $request->service_id,
            'price' => $request->price,
            'created_at' => $request->date,
            'status' => 'disponible', // Asegurar que el estado sea válido
        ]);

        return redirect()->route('movements.index', compact('accounts'))->with('success', 'Movimiento registrado correctamente.');
    }

    public function createAccount(Request $request)
    {
        // Autorizar la creación de cuentas
        $this->authorize('create', Account::class);
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'service_id' => 'required|exists:services,id',
            'email_account' => 'required|email',
            'pass_account' => 'required',
            'price' => 'required|numeric|min:0',
            'date_pay' => 'required|date',
        ]);

        // Obtener el tipo de cuenta desde la base de datos
        $service = Service::find($request->service_id);
        $typeAccount = $service->accounts()->first()->type_account;

        // Crear la cuenta
        $account = Account::create([
            'client_id' => $request->client_id,
            'service_id' => $request->service_id,
            'email_account' => $request->email_account,
            'pass_account' => $request->pass_account,
            'type_account' => $typeAccount,
            'price' => $request->price,
            'date_pay' => $request->date_pay,
            'status' => 'Activo',
        ]);

        // Si el tipo de cuenta es "perfiles", crear los perfiles asociados
        if ($typeAccount === 'perfiles') {
            $profilesNumber = $service->service_profiles;

            for ($i = 0; $i < $profilesNumber; $i++) {
                $account->accountProfiles()->create([
                    'profile_number' => $i + 1,
                ]);
            }
        }

        return redirect()->route('movements.index')->with('success', 'Cuenta creada correctamente.');
    }

    public function search(Request $request)
    {
        // Validamos que el usuario tenga los roles adecuados
        // if (!auth()->user()->hasRole(['Super Admin', 'Admin', 'Reseller'])) {
        //     return response()->json(['error' => 'No autorizado'], 403);
        // }

        // Autorizar acceso a la búsqueda de cuentas
        $this->authorize('viewAny', Account::class);
        
        $searchTerm = $request->input('search');
        $query = Account::with(['clients', 'service']);
        
        if (!empty($searchTerm)) {
            $query->where(function($q) use ($searchTerm) {
                $q->where('email_account', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhereHas('clients', function ($subq) use ($searchTerm) {
                      $subq->where('name_client', 'LIKE', '%' . $searchTerm . '%');
                  });
            });
        }
        
        $accounts = $query->limit(10)->get();
        
        // Transformamos los datos para un mejor formato de respuesta
        $results = $accounts->map(function($account) {
            return [
                'id' => $account->id,
                'email' => $account->email_account,
                'client_name' => $account->clients ? $account->clients->name_client : 'N/A',
                'service_name' => $account->service ? $account->service->name_service : 'N/A'
            ];
        });
        
        return response()->json($results);
    }
    public function viewMovementDetails($id)
    {
        try {
            // Recuperar la cuenta
            $account = Account::findOrFail($id);
            // Autorizar acceso a los detalles de la cuenta
            $this->authorize('view', $account);
            // Devolver la vista
            return view('movements.view', compact('account'));
        } catch (\Exception $e) {
            return '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
        }
    }

    // public function createAccountSaleModal($id)
    // {
    //     try {
    //         $account = Account::findOrFail($id);
    //         return view('movements.account_sale', compact('account'));
    //     } catch (\Exception $e) {
    //         return redirect()->route('movements.index')->with('error', 'Error: ' . $e->getMessage());
    //     }
    // }

    public function createAccountSaleModal($id)
    {
        try {
            // Recuperar la cuenta
            $account = Account::findOrFail($id);
            // Autorizar acceso a la creación de ventas de cuentas
            $this->authorize('create', Account::class);

            return view('movements.account_sale', compact('account'));
        } catch (\Exception $e) {
            return '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
        }
    }
    
}