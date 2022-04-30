<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\Invitation;
use App\Notifications\SendInvitationNotification;
use Illuminate\Support\Facades\Notification;
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

        Notification::route('mail', $request->email)
            ->notify(new SendInvitationNotification($invitation));

        return redirect()->route('users.index');
    }

    public function acceptInvitation($token)
    {
        $invitation = Invitation::where('token', $token)
            ->whereNull('accepted_at')
            ->firstOrFail();

        if (auth()->check()) {
            // assign a user
        } else {
            // redirect to register
        }
    }
}
