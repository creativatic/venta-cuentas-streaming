<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserRoleController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AccountProfileController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return auth()->check() ? redirect('dashboard') : view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('admin')->name('admin.')->group(function () {
        // Gestión de Roles
        Route::resource('/roles', RoleController::class);   
        // Gestión de Permisos
        Route::resource('/permissions', PermissionController::class);
        // Gestión de Usuarios
        Route::resource('/users', UserController::class);
        // Asignación de roles a usuarios
        Route::get('users/{user}/roles', [UserRoleController::class, 'edit'])->name('users.roles.edit');
        Route::put('users/{user}/roles', [UserRoleController::class, 'update'])->name('users.roles.update');
        // Endpoint para obtener permisos por roles (AJAX)
        Route::post('users/get-permissions-for-roles', [UserRoleController::class, 'getPermissionsForRoles'])
        ->name('users.get-permissions-for-roles');
    });

    // CRUD de company 
    Route::resource('/companies', CompanyController::class);

    // CRUD de clients 
    Route::resource('/clients', ClientController::class);
    // Agregar la ruta específica para abrir el modal
    Route::get('/clients/create-modal/{id}', [ClientController::class, 'createAccountModal'])->name('clients.create_modal');
    Route::get('/clients/show-modal/{id}', [ClientController::class, 'showModal'])->name('clients.show_modal');
    Route::get('/clients/edit-modal/{id}', [ClientController::class, 'editModal'])->name('clients.edit_modal');
    

    // CRUD de accounts 
    Route::resource('/accounts', AccountController::class);

    // CRUD de servicios
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');
    Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');

    // Gestión  de movimientos
    Route::get('/movements', [MovementController::class, 'index'])->name('movements.index');
    Route::post('/movements', [MovementController::class, 'store'])->name('movements.store');
    // Rutas para ver detalles
    Route::get('/movements/view/{id}', [MovementController::class, 'viewMovementDetails'])
        ->where('id', '[0-9]+')
        ->name('movements.view');
    // Ruta para búsqueda
    Route::get('/movements/search', [MovementController::class, 'search'])->name('movements.search');
    // Ruta para detalles de cuentas
    Route::get('/movements/details/{account}', [MovementController::class, 'details'])->name('movements.details');
    // Ruta para crear modal de venta
    Route::get('/movements/create-modal/{id}', [MovementController::class, 'createAccountSaleModal'])->where('id', '[0-9]+')
     ->name('movements.create.modal');
    //Route::get('/movements/{id}', [MovementController::class, 'index'])->name('movements.show'); // Temporalmente enlazado al index
    //Route::get('/movements/search', [MovementController::class, 'search'])->name('movements.search');

    // CRUD de perfiles de las cuentas 
    Route::put('/account_profiles/{id}', [AccountProfileController::class, 'update'])->name('account_profiles.update');
    Route::get('/account_profiles/view/{id}', [AccountProfileController::class, 'getProfileView'])->name('account_profiles.view');

    // CRUD para perfiles segun asociacion de cuentas y servicios desde la vista index movimientos
    Route::post('/movements/createAccount', [MovementController::class, 'createAccount'])->name('movements.createAccount');

});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/'); // Redirige al home después de cerrar sesión
})->name('logout');

// Route::middleware(['auth'])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     });
// });

require __DIR__.'/auth.php';
