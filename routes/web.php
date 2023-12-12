<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\SocioController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\CobranzaController;
use App\Http\Controllers\CuentaEgresoController;
use App\Http\Controllers\CuentaSocioController;
use App\Http\Controllers\DeudaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\GaiaController;
use App\Models\CuentaSocio;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();
// PDF
Route::group(['middleware' => ['auth']], function () {
    Route::get('/persona/pdf', [PersonaController::class, 'generarPersonaPDF']);
});
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RolController::class);
    Route::resource('usuarios', UsuarioController::class);
    // Route::resource('blogs', BlogController::class);
    Route::resource('persona', PersonaController::class);
    Route::resource('socio', SocioController::class);
    Route::resource('cargo', CargoController::class);
    Route::resource('cobranza', CobranzaController::class);
    Route::resource('deuda', DeudaController::class);

    // Route::resource('pago', PagoController::class);
    Route::get('persona/updateState/{id}', [PersonaController::class, 'updateState'])->name('persona.updateState');

    // PAGO
    Route::get('/pago', [PagoController::class, 'index']);
    Route::post('/guardarPago', [PagoController::class, 'guardarPago']);
    Route::post('/guardarGasto', [CuentaEgresoController::class, 'guardarGasto']);

    // obtenemos la cuenta del socio
    Route::post('/obtenerCuentaSocio', [CuentaSocioController::class, 'obtenerCuentaSocio']);
    Route::post('/obtenerMontoSocio', [CuentaSocioController::class, 'obtenerMontoSocio']);

    Route::post('/buscarDeudaSocio', [DeudaController::class, 'buscarDeudaSocio']);
    Route::post('/buscarDeuda', [DeudaController::class, 'buscarDeuda']);
    Route::post('/pagarDeuda', [DeudaController::class, 'pagarDeuda']);
    
    // Nuevo capitulo
    Route::get('/gaia', [GaiaController::class, 'index']);
    Route::post('/prueba', [DeudaController::class, 'prueba']);

});

Route::middleware(['auth'])->post('/editProfile/{id}', [UsuarioController::class, 'editProfile']);
Route::middleware(['auth'])->post('/buscarPersona', [PersonaController::class, 'buscarPersona']);
Route::middleware(['auth'])->post('/obtenerUsuario', [UsuarioController::class, 'obtenerUsuario']);
Route::middleware(['auth'])->post('/obtenerArticulo', [PagoController::class, 'obtenerArticulo']);
Route::middleware(['auth'])->post('/buscarSocio', [SocioController::class, 'buscarSocio']);





