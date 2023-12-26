<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Socialite\Facades\Socialite;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function providerRedirect($provider): RedirectResponse
    {
        return Socialite::driver($provider)->redirect();
    }

    public function providerCallback($provider): RedirectResponse
    {
        $socialUser = Socialite::driver($provider)->user();

        $user = User::updateOrCreate([
            // 'provider_id' => $socialUser->id,
            // 'provider' => $provider,
            'email' => $socialUser->email,
        ], [
            'provider_id' => $socialUser->id,
            'provider' => $provider,
            'name' => $socialUser->name,
            'email' => $socialUser->email,
            'provider_token' => $socialUser->token,
            'email_verified_at' => now(),
        ]);

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
