<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\UserStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Stancl\Tenancy\Facades\Tenancy;
use App\RolesEnum;

class AuthenticatedSessionController extends Controller
{
    // Fix the return type issue by allowing either a View or RedirectResponse
    public function index(): View|RedirectResponse
    {
        if (Auth::check()) {
            // Redirect authenticated user to their appropriate dashboard
            return $this->redirectUser(auth()->user());
        }
        // Return welcome view for non-authenticated users
        return view('welcome');
    }

    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the incoming request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Add tenant_id if available
        $credentials = $request->only('email', 'password');
        if ($tenantId = tenant('id')) {
            $credentials['tenant_id'] = $tenantId;
        }
        $credentials['status'] = UserStatus::ACTIVE->value;

        // Attempt to authenticate the user
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Redirect user to their dashboard after successful login
            return $this->redirectUser(auth()->user());
        }

        // Authentication failed, redirect back with an error
        return back()->withInput()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    private function redirectUser($user): RedirectResponse
    {
        if ($user->hasRole(RolesEnum::SUPERADMIN)) {
            // Redirect to admin dashboard if user is a superadmin
            return redirect()->intended(route('admin.dashboard'));
        } elseif ($user->hasRole(RolesEnum::SITEMANAGER) || $user->hasRole(RolesEnum::SITEUSER)) {
            // Redirect to site dashboard if user is a site manager or site user
            return redirect()->intended(route('site.dashboard'));
        } elseif ($user->hasRole(RolesEnum::SITEDRIVER)) {
            // Redirect to driver dashboard if user is a site driver
            return redirect()->intended(route('driver.dashboard'));
        }

        // Fallback redirect in case none of the roles match (optional)
        return redirect()->intended(route('default.dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Log the user out and invalidate the session
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the home page or the app URL
        return redirect(env('APP_URL'));
    }

    /**
     * Display the site login view.
     */
    public function siteLogin(): View
    {
        return view('site.auth.login');
    }
}
