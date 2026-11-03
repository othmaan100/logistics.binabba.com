<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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
    public function store(LoginRequest $request): RedirectResponse
    {
        // $request->authenticate();

        // $request->session()->regenerate();

        // return redirect()->intended(route('dashboard', absolute: false));

        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();
        $role = $user->role;
        
        
        ActivityLog::create([
            "user_id"=> $user->id,
            "activity"=> "Looged in"
        ]);

        if ($user->status != 1) {
            return redirect()->route('denied');
            
        }

        if ($role == 1) {
            return redirect()->route('dashboard');
        }
        elseif ($role == 2) {
            return redirect()->route('staff_dashboard');
        }
        else{
           return redirect()->route('denied');
           //return redirect()->route('dashboard');
        }




    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        ActivityLog::create([
            "user_id"=> Auth::id(),
            "activity"=> "Looged out"
        ]);

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
