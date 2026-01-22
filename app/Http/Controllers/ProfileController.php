<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProfileController extends Controller
{
    public function index() {
        $user = Auth::user();
        return view('users.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'  => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        // AJAX
        if ($request->ajax()) {
            return response()->json([
                'message' => 'Profile updated successfully.',
                'user' => $user->only(['name', 'email']),
            ]);
        }

        // fallback (non-AJAX)
        return redirect()
            ->route('profile.index')
            ->with('success', 'Profile updated!');
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'old_password' => ['required'],
            'new_password' => ['required', 'min:8', 'confirmed'],
        ]);

        // Check old password
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors([
                'old_password' => 'Old password is incorrect.',
            ])->withInput();
        }

        // Prevent same password
        if (Hash::check($request->new_password, $user->password)) {
            return back()->withErrors([
                'new_password' => 'New password must be different from the old password.',
            ])->withInput();
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }

    public function updateAvatar(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $manager = new ImageManager(new Driver());

        $image = $manager->read($request->file('avatar'));

        $size = min($image->width(), $image->height());

        $image->crop(
            $size,
            $size,
            ($image->width() - $size) / 2,
            ($image->height() - $size) / 2
        );

        $filename = uniqid() . '.' . $request->file('avatar')->getClientOriginalExtension();
        $path = 'profile/' . $filename;

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        Storage::disk('public')->put($path, $image->toJpeg());

        $user->update([
            'avatar' => $path,
        ]);

        return back()->with('success', 'Profile picture updated.');
    }
}