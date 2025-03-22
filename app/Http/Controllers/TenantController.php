<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class TenantController extends Controller
{
    public static function index(): \Stancl\Tenancy\Database\TenantCollection
    {
        return Tenant::all();
    }

    public function maintenance(Tenant $tenant)
    {
        $tenant->putDownForMaintenance();

        return Redirect::route('dashboard')->with('message', 'Tenant is now in maintenance mode.');
    }

    public function restore(Tenant $tenant)
    {
        $tenant->update(['maintenance_mode' => null]);

        return Redirect::route('dashboard')->with('message', 'Tenant is now live.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|max:255|string|unique:tenants',
        ]);

        $name = Str::slug($request->id);
        $tenant = Tenant::create([
            'id' => $name,
        ]);
        $tenant->domains()->create([
            'domain' => $name . '.localhost',
        ]);

        return Redirect::route('dashboard')->with('message', 'Tenant created successfully.');
    }

    public function destroy(Tenant $tenant)
    {
        $tenant->delete();

        return Redirect::route('dashboard')->with('message', 'Tenant deleted successfully.');
    }
}
