<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
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

        // Log at the beginning of the method
        Log::info('ProfileController update - Start');
        Log::info('User photo at start: ' . ($user->photo ? $user->photo : 'null')); // Handle null photo
        Log::info('Request validated data: ' . json_encode($request->validated()));

        // Fill only non-photo data
        $data = $request->validated();
        unset($data['photo']); // make sure it's not there
        $user->fill($data);

        // Log after fill
        $data = $request->validated();
        unset($data['photo']); // make sure it's not there

        $user->fill($data);
        Log::info('User photo after fill (should be original or null): ' . ($user->photo ? $user->photo : 'null')); // Handle null photo


        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            Log::info('Uploaded file name: ' . $file->getClientOriginalName());
            Log::info('Uploaded file temporary path: ' . $file->getPathname());

            $path = $file->store('profile-photos', 's3');

            Log::info('Stored file path (from S3/R2): ' . ($path ? $path : 'false or null')); // Log result of store()

            if ($path) {
                // Delete old photo from S3/R2 if exists
                if ($user->getOriginal('photo')) {
                    Storage::disk('s3')->delete($user->getOriginal('photo'));
                    Log::info('Old photo path: ' . $user->getOriginal('photo'));
                    Log::info('Deleted old photo: ' . $user->getOriginal('photo'));
                }
                $user->photo = $path;
                Log::info('User photo attribute set to stored path: ' . $user->photo);
            } else {
                Log::warning('File storage failed. $path is not set.');
            }
        } else {
            Log::info('No photo file uploaded.');
        }
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        Log::info('User photo after fill (should be original or null): ' . ($user->photo ? $user->photo : 'null')); // Handle null photo
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
