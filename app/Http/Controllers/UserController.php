<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\Invitation;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $invitations = Invitation::latest()->get();

        return view('users.index', compact('invitations'));
    }

    public function store(StoreUserRequest $request)
    {
        $invitation = Invitation::create([
            'tenant_id' => auth()->user()->current_tenant_id,
            'email' => $request->email,
            'token' => Str::random(32)
        ]);

        return redirect()->route('users.index');
    }
}
