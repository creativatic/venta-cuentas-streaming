<?php

namespace App\Http\Controllers;

use App\Models\AccountProfile;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Profiler\Profile;

class AccountProfileController extends Controller
{
    // Muestra el formulario para crear un nuevo perfil de cuenta
    public function create()
    {
        $accounts = Account::all(); // Obtenemos todas las cuentas para poder seleccionar una
        return view('account_profiles.create', compact('accounts'));
    }

    // Almacena un nuevo perfil de cuenta
    public function store(Request $request)
    {
        $validated = $request->validate([
            'profile_number' => 'required|integer',
            'profile_name' => 'required|string|max:255',
            'profile_pin' => 'nullable|string|max:10',
            'price' => 'required|numeric',
            'pay' => 'required|numeric',
            'total_pay' => 'required|numeric',
            'next_pay' => 'required|numeric',
            'date_pay' => 'required|date',
            'next_date_pay' => 'required|date',
            'renewal_date_profile' => 'required|date',
            'status_profile' => 'required|string|max:20',
            'description' => 'nullable|string|max:255',
            'accounts_id' => 'required|exists:accounts,id',
        ]);

        AccountProfile::create($validated);

        return redirect()->route('account_profiles.index')->with('success', 'Perfil creado correctamente');
    }

    public function show($id)
    {
        try {
            $profile = AccountProfile::findOrFail($id);
            
            return view('account_profiles.show', compact('profile'));
        } catch (\Exception $e) {
            Log::error('Error al mostrar perfil ID '.$id.': '.$e->getMessage());
            return response()->view('errors.custom', [
                'message' => 'No se pudo cargar el perfil solicitado'
            ], 500);
        }
    }

    // Muestra el formulario para editar un perfil de cuenta
    public function edit($id)
    {
        try {
            $profile = AccountProfile::findOrFail($id);
            
            return view('account_profiles.edit', compact('profile'));
        } catch (\Exception $e) {
            Log::error('Error al editar perfil ID '.$id.': '.$e->getMessage());
            return response()->view('errors.custom', [
                'message' => 'No se pudo cargar el formulario de edición'
            ], 500);
        }
    }

    // Actualiza un perfil de cuenta existente
    public function update(Request $request, $id)
    {
        try {
            $profile = AccountProfile::findOrFail($id);
            
            // Validación básica
            $validated = $request->validate([
                'profile_number' => 'required',
                'profile_name' => 'required',
                'profile_pin' => 'required',
                'price' => 'required|numeric',
                'status_profile' => 'required|in:activo,pendiente,vencio,disponible',
            ]);
            
            // Debug - registrar datos recibidos
            Log::info('Actualizando perfil ID '.$id, $request->all());
            
            // Actualizar solo los campos permitidos
            $profile->fill($request->only([
                'profile_number',
                'profile_name',
                'profile_pin',
                'price',
                'status_profile',
                // No incluimos accounts_id para evitar cambiar la relación
            ]));
            
            // Guardar explícitamente
            $result = $profile->save();
            
            // Registrar el resultado
            Log::info('Resultado de actualización: '.($result ? 'Éxito' : 'Fallo'));
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Perfil actualizado correctamente',
                    'profile' => $profile
                ]);
            }
            
            return redirect()->route('account_profiles.show', $profile->id)
                ->with('success', 'Perfil actualizado correctamente');
                
        } catch (\Exception $e) {
            Log::error('Error al actualizar perfil ID '.$id.': '.$e->getMessage());
            Log::error($e->getTraceAsString());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar el perfil: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->withErrors(['error' => 'Error al actualizar el perfil: ' . $e->getMessage()]);
        }
    }
    
    // Elimina un perfil de cuenta
    public function destroy($id)
    {
        $accountProfile = AccountProfile::findOrFail($id);
        $accountProfile->delete();

        return redirect()->route('account_profiles.index')->with('success', 'Perfil eliminado correctamente');
    }

    public function editPartial($id)
    {
        $accountProfile = AccountProfile::findOrFail($id);
        $accounts = Account::all(); // Obtener cuentas si es necesario
        return view('account_profiles.edit', compact('accountProfile', 'accounts'));
    }

    public function getProfileView($id)
    {
        try {
            // Recuperar el perfil con información relacionada si es necesario
            $profile = AccountProfile::findOrFail($id);
            
            // Registrar información para depuración
            Log::info('Perfil recuperado', [
                'id' => $id,
                'status' => $profile->status_profile,
                'nombre' => $profile->profile_name
            ]);

            // Normalizar el estado para evitar problemas con espacios o mayúsculas
            $status = strtolower(trim($profile->status_profile ?? ''));
            
            // Determinar la vista según el estado del perfil normalizado
            if ($status === "activo") {
                Log::info('Cargando vista show');
                return view('account_profiles.show', compact('profile'));
            } elseif (empty($status) || in_array($status, ["vencio", "pendiente", "disponible"])) {
                Log::info('Cargando vista edit');
                return view('account_profiles.edit', compact('profile'));
            }

            // Si no coincide con ninguna condición, mostrar un mensaje de error
            Log::warning('Estado de perfil no reconocido', ['status' => $status]);
            return '<div class="alert alert-warning">Estado de perfil no reconocido: ' . $profile->status_profile . '</div>';
            
        } catch (\Exception $e) {
            // Registrar el error
            Log::error('Error al cargar la vista del perfil', [
                'id' => $id,
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Devolver un mensaje de error más amigable
            return '<div class="alert alert-danger">
                <h4>Error al cargar los detalles del perfil</h4>
                <p>' . $e->getMessage() . '</p>
                <p>Por favor intente nuevamente o contacte al administrador.</p>
            </div>';
        }
    }

}