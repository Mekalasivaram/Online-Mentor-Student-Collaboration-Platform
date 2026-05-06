<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit() {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request) {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);
        
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        if ($user->role === 'mentor') {
            $user->mentor->update($request->only('expertise', 'experience', 'bio', 'availability'));
        } elseif ($user->role === 'student') {
            $user->student->update($request->only('college', 'course', 'year'));
        }

        return back()->with('success', 'Profile updated successfully!');
    }
}
