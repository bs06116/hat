<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Stancl\Tenancy\Facades\Tenancy;
use App\RolesEnum;

class AuthenticatedSessionController extends Controller
{
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

     public function store(Request $request)
{
    // Validate the incoming request data
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');

    // Check if tenant ID is available
    if ($tenantId = tenant('id')) {
        $credentials['tenant_id'] = $tenantId;
    }

    // Attempt to authenticate the user
    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        return $this->redirectUser(auth()->user());
    }

    // Authentication failed, redirect back with an error
    return back()->withInput()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);

}
private function redirectUser($user)
{
    if (empty(tenant('id'))) {
        if ($user->hasRole(RolesEnum::SUPERADMIN)) {
            return redirect()->intended(route('admin.dashboard'));
        }
    } else {
        return redirect()->intended(route('site.dashboard'));
    }
}

    // public function store(LoginRequest $request): RedirectResponse
    // {
       
    //     $request->authenticate();
    //     $request->session()->regenerate();
        
    //     if (Auth::user()->role === 'super-admin') {
    //         return redirect()->intended(default: route('AdminDashboard', absolute: false));
    //     }else{
    //         return redirect()->intended(default: route('dashboard', absolute: false));

    //     }
    // }

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

     /**
     * Display the login view.
     */
    public function siteLogin(): View
    {
        return view('site.auth.login');
    }
}
