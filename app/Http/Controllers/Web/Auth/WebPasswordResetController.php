<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;

class WebPasswordResetController extends Controller
{
    // -------------------------------------------------------
    // PART 1: FORGOT PASSWORD (The Email Form)
    // -------------------------------------------------------

    /**
     * Show the form where user enters their email.
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle the form submission to send the reset link.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Attempt to send the link
        $status = Password::sendResetLink($request->only('email'));

        // If successful, redirect back with a success status (Blade will show this)
        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        // If failed (e.g., email not found), redirect back with errors
        return back()->withErrors(['email' => __($status)]);
    }

    // -------------------------------------------------------
    // PART 2: RESET PASSWORD (The New Password Form)
    // -------------------------------------------------------

    /**
     * Show the form to create a new password.
     * The $token comes from the URL (clicked in email).
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset-password')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Handle the actual password reset logic.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => [
                'required',
                'confirmed',
                PasswordRule::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
        ]);

        // Attempt to reset the password
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If successful, redirect to LOGIN page with success message
        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __($status));
        }

        // If failed (e.g., invalid token), redirect back with errors
        return back()->withErrors(['email' => __($status)]);
    }
}