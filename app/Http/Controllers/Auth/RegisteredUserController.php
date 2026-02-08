<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request): RedirectResponse
    {
        if (setting('registration_enabled', '1') !== '1') {
            abort(403);
        }
        $user = User::create($request->validated());

        event(new Registered($user));

        auth()->login($user);

        return redirect()->route('dashboard');
    }
}
