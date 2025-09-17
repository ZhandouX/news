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
    // EDIT ACCOUNT
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    // PROFILE ADMIN ACCOUNT 
    public function profileAdmin(Request $request): View
    {
        return view('profile.profile-admin', [
            'user' => $request->user(),
        ]);
    }
    
    // PROFILE SUPER ADMIN ACCOUNT
    public function profileSuperAdmin(Request $request): View
    {
        return view('profile.profile-super-admin', [
            'user' => $request->user(),
        ]);
    }

    // UPDATE ACCOUNT
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Mapping role ke route profil masing-masing
        $roleRoutes = [
            'super-admin' => 'profile.profile-super-admin',
            'admin'       => 'profile.profile-admin',
            'user'        => 'profile.edit',
        ];

        // Ambil role pertama user, fallback ke 'user'
        $role = $user->getRoleNames()->first() ?? 'user';

        $route = $roleRoutes[$role] ?? 'profile.edit';

        return Redirect::route($route)->with('status', 'profile-updated');
    }

    // DELETE ACCOUNT
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
