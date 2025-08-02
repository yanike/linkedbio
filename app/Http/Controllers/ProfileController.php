<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
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

        // Separate photo handling from filling other data
        $validatedData = $request->validated();

        // Fill validated data (but not photo yet)
        $user->fill($validatedData);

        // Handle photo upload if a file is present
        if ($request->hasFile('photo')) {
            // Store the photo on the 'r2' disk
            $path = $request->file('photo')->store('profile-photos', 'r2');

            if ($path) {
                // Optional: delete old photo
                if ($user->getOriginal('photo') && Storage::disk('r2')->exists($user->getOriginal('photo'))) {
                    Storage::disk('public')->delete($user->getOriginal('photo'));
                }

                $user->photo = $path;
            }
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
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
