<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'credit_card_number' => ['nullable','digits:16'],
        ]);
        
        $creditCardVerified = $this->validateCreditCard($request->credit_card_number);
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'credit_card_number' => $request->credit_card_number,
            'credit_card_verified' => $creditCardVerified,
        ]);

        if ($user->credit_card_verified) {
            $user->assignRole('userCCT');
        } else {
            $user->assignRole('userCCF');
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    private function validateCreditCard($creditCardNumber)
    {
        // if CCN is 16 digits, return true
        if (strlen($creditCardNumber) !== 16) {
            return false;
        }
        return true;
    }
}
