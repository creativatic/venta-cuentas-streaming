<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountProfile;
use App\Models\Client;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        // Autorizar acceso a la lista de cuentas
        $this->authorize('viewAny', Account::class);
        $accounts = Account::with(['user', 'service'])->get();
        return view('accounts.index', compact('accounts'));
    }

    public function create()
    {
        // Autorizar la creación de cuentas
        $this->authorize('create', Account::class);

        $users = User::all();
        $services = Service::all();
        $currentDate = Carbon::now()->format('Y-m-d');
        $renewalDate = Carbon::now()->addDays(31)->format('Y-m-d');
        
        return view('accounts.create', compact('users', 'services', 'currentDate', 'renewalDate'));
    }

    public function store(Request $request)
    {
        // Autorizar la creación de cuentas
        $this->authorize('create', Account::class);
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'services_id' => 'required|exists:services,id',
            'name_account' => 'required|string|max:255',
            'email_account' => 'required|email|max:255',
            'pass_account' => 'required|string|max:255',
            'type_account' => 'required|string|max:20', 
            'price' => 'required|numeric',
            'available_profiles' => 'required|integer', 
            'used_profiles' => 'required|integer', 
            'date_pay' => 'required|date',
            'renewal_date_account' => 'required|date',
            'status' => 'required|string|max:20',
            'description' => 'nullable|string',
        ]);

        // Encriptar la contraseña antes de guardarla (OPCIONAL)
        // $request->merge(['pass_account' => bcrypt($request->pass_account)]);

        // Crear la cuenta
        $account = Account::create($request->all());

        // Obtener el servicio seleccionado
        $service = Service::find($request->services_id);

        // Generar los perfiles según el valor de service_profiles
        for ($i = 1; $i <= $service->service_profiles; $i++) {
            AccountProfile::create([
                'profile_number' => $i, // Número de perfil (1, 2, 3, ...)
                'profile_name' => 'Perfil ' . $i, // Nombre predeterminado
                'profile_pin' => str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT), // PIN aleatorio de 4 dígitos
                'price' => $service->price, // Precio del servicio
                'accounts_id' => $account->id, // ID de la cuenta creada
            ]);
        }

        return redirect()->route('accounts.index')->with('success', 'Account created successfully.');
    }
    
    public function show(Account $account)
    {
        // Autorizar acceso a los detalles de la cuenta
        $this->authorize('view', $account);
        return view('accounts.show', compact('account'));
    }

    public function edit(Account $account, $id)
    {

        $account = Account::findOrFail($id);

        // Autorizar la actualización de la cuenta
        $this->authorize('update', $account);

        $users = User::all();
        $services = Service::all();
        return view('accounts.edit', compact('account', 'users', 'services'));
    }

    public function update(Request $request, Account $account, $id)
    {
        $account = Account::findOrFail($id);

        // Autorizar la actualización de la cuenta
        $this->authorize('update', $account);
        
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'services_id' => 'required|exists:services,id',
            'name_account' => 'required|string|max:255',
            'email_account' => 'required|email|max:255',
            'pass_account' => 'nullable|string|max:255',
            'type_account' => 'required|string|max:20', 
            'price' => 'required|numeric',
            'available_profiles' => 'required|integer', 
            'used_profiles' => 'required|integer', 
            'date_pay' => 'required|date',
            'renewal_date_account' => 'required|date',
            'status' => 'required|string|max:20',
            'description' => 'nullable|string',
        ]);

        // Si se proporcionó una nueva contraseña, actualizar todos los campos
        // No encriptar la contraseña, ya que es temporal
        if ($request->filled('pass_account')) {
            $account->update($request->all());
        } else {
            // Si no se proporcionó contraseña, actualizar todos los campos excepto la contraseña
            $account->update($request->except('pass_account'));
        }

        return redirect()->route('accounts.index')->with('success', 'Account updated successfully.');
    }
    

    public function destroy(Account $account, $id)
    {
        $account = Account::findOrFail($id);

        // Autorizar la eliminación de la cuenta
        $this->authorize('delete', $account);
        
        $account->delete();
        return redirect()->route('accounts.index')->with('success', 'Account deleted successfully.');
    }
    public function client()
    {
        return $this->belongsTo(Client::class, 'user_id'); // Ajusta si la FK es diferente
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'services_id');
    }
}