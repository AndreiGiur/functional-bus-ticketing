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
    public function edit(Request $request): View
    {
        // Ensure the correct user is fetched
        $user = $request->user();

        return view('profile.edit', [
            'user' => $user,
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Get the authenticated user
        $user = $request->user();

        // Get the validated data from the request
        $validatedData = $request->validated();

        $user->fill($validatedData);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', __('Profile updated successfully.'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        // Validate that the password is correct before deletion
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        // Get the authenticated user
        $user = $request->user();

        // Logout the user before deleting the account
        Auth::logout();

        // Delete the user account
        $user->delete();

        // Invalidate the session and regenerate the CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the homepage with a success message
        return Redirect::to('/')->with('status', __('Account deleted successfully.'));
    }
}
