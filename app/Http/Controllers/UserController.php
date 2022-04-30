<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\Invitation;
use App\Notifications\SendInvitationNotification;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $invitations = Invitation::where('tenant_id', auth()->user()->current_tenant_id)->latest()->get();

        return view('users.index', compact('invitations'));
    }

    public function store(StoreUserRequest $request)
    {
        $invitation = Invitation::create([
            'tenant_id' => auth()->user()->current_tenant_id,
            'email' => $request->email,
            'token' => Str::random(32)
        ]);

        Notification::route('mail', $request->email)
            ->notify(new SendInvitationNotification($invitation));

        return redirect()->route('users.index');
    }

    public function acceptInvitation($token)
    {
        $invitation = Invitation::with('tenant')
            ->where('token', $token)
            ->whereNull('accepted_at')
            ->firstOrFail();

        if (auth()->check()) {
            $invitation->update(['accepted_at' => now()]);

            auth()->user()->tenants()->attach($invitation->tenant_id);

            auth()->user()->update(['current_tenant_id' => $invitation->tenant_id]);

            $tenantDomain = str_replace('://', '://' . $invitation->tenant->subdomain . '.', config('app.url'));
            return redirect($tenantDomain . RouteServiceProvider::HOME);
        } else {
            return redirect()->route('register', ['token' => $invitation->token]);
        }
    }
}
