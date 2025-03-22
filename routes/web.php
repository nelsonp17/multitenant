<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TenantController;
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

// rutas del dominio central
foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () {
        Route::get('/', function () {
            return view('welcome');
        });
        Route::post("/tenant", [TenantController::class, 'store'])->name('tenant.store');
        Route::delete("/tenant/{tenant}", [TenantController::class, 'destroy'])->name('tenant.destroy');
        Route::get("/tenant/{tenant}/maintenance", [TenantController::class, 'maintenance'])->name('tenant.maintenance');
        Route::get("/tenant/{tenant}/restore", [TenantController::class, 'restore'])->name('tenant.restore');
    });
}






Route::get('/dashboard', function () {
    return view('dashboard', [
        "tenants" => TenantController::index(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
