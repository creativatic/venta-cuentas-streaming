<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Mostrar una lista de todas las compañías.
     */
    public function index()
    {
        $companies = Company::all(); // Obtener todas las compañías
        return view('companies.index', compact('companies'));
    }

    /**
     * Mostrar el formulario para crear una nueva compañía.
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * Guardar una nueva compañía en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'business_name' => 'required|string|max:255',
            'tax_id' => 'nullable|string|max:20|unique:companies',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'currency' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Crear la compañía
        Company::create($request->all());

        return redirect()->route('companies.index')->with('success', 'Compañía creada correctamente.');
    }

    /**
     * Mostrar los detalles de una compañía específica.
     */
    public function show(Company $company)
    {
        return view('companies.show', compact('company'));
    }

    /**
     * Mostrar el formulario para editar una compañía existente.
     */
    public function edit(Company $company)
    {
        // Si el usuario no es Super Admin y no es dueño de la compañía, denegar acceso
        if (!auth()->user()->hasRole('Super Admin') && auth()->user()->company_id !== $company->id) {
            abort(403, 'No tienes permiso para editar esta empresa.');
        }
        return view('companies.edit', compact('company'));
    }

    /**
     * Actualizar una compañía en la base de datos.
     */
    public function update(Request $request, Company $company)
    {
        // Si el usuario no es Super Admin y no es dueño de la compañía, denegar acceso
        if (!auth()->user()->hasRole('Super Admin') && auth()->user()->company_id !== $company->id) {
            abort(403, 'No tienes permiso para editar esta empresa.');
        }
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'business_name' => 'required|string|max:255',
            'tax_id' => 'nullable|string|max:20|unique:companies,tax_id,' . $company->id,
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'currency' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Actualizar la compañía
        $company->update($request->all());

        return redirect()->route('companies.index')->with('success', 'Compañía actualizada correctamente.');
    }

    /**
     * Eliminar una compañía de la base de datos.
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('companies.index')->with('success', 'Compañía eliminada correctamente.');
    }
}