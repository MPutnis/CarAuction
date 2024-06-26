<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $validatedData = $request->validated();

        // Validate the credit card
        if (isset($validatedData['credit_card_number'])) {
            $creditCardVerified = $this->validateCreditCard($validatedData['credit_card_number']);
            $validatedData['credit_card_verified'] = $creditCardVerified;
        } else {
            $creditCardVerified = false;
            $user->credit_card_verified = false;
        }

        if ($creditCardVerified) {
            $user->syncRoles(['userCCT']);
        } else {
            $user->syncRoles(['userCCF']);
        }

        $user->fill($validatedData);
        
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
    private function validateCreditCard($creditCardNumber)
    {
        // if CCN is 16 digits, return true
        return strlen($creditCardNumber) === 16;
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
