<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminProfileController extends Controller
{
    public function show()
    {
        $admin = \App\Models\Admin::find(session('admin_id'));
        return view('admin.profile', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = \App\Models\Admin::find(session('admin_id'));

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email,' . $admin->id,
            'avatar' => 'nullable|image|max:2048',
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;

        if ($request->password) {
            $admin->password = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $admin->avatar = $path;
        }

        $admin->save();

        return redirect()->route('admin.profile')->with('success', 'Profile updated!');
    }
}