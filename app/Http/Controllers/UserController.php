<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Stancl\Tenancy\Database\Models\Domain;

class UserController extends Controller
{
    public function destroy()
    {
        $tenants = auth()->user()->tenants;
        foreach ($tenants as $tenant) {
            DB::transaction(function() use ($tenant) {
                Domain::where('tenant_id', $tenant->id)->delete();
                auth()->user()->tenants()->detach($tenant->id);
                $tenant->delete();
                auth()->user()->delete();
            });
        }

        auth()->logout();
        return redirect()->route('homepage');
    }
}
