<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('pages.app.profile', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'pasword_lama' => 'required',
            'password_baru' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (Hash::check($request->password_lama, $user->password)) {
            DB::table('users')
                ->where('id', $user->id)
                ->update(['password' => Hash::make($request->password_baru)]);


            return redirect()->route('profile.show')->with('success', 'Password updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }
    }

    public function show()
    {
        $user = Auth::user();
        return response()->json([
            'message' => 'Data Ditemukan',
            'user' => $user
        ]);
    }

    public function edit(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required'
        ]);
        /** @var \App\Models\User $user **/
        $user->update($validated);
        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user
        ], 200);
    }







    public function updatPassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required',
        ]);

        // Memverifikasi bahwa password lama sesuai dengan password di database
        if (!Hash::check($request->password_lama, $user->password)) {
            return response()->json(['message' => 'Password lama tidak sesuai'], 400);
        }

        // Update password baru
        /** @var \App\Models\User $user **/
        $user->update([
            'password' => Hash::make($request->password_baru),
        ]);

        return response()->json(['message' => 'Password berhasil diubah']);
    }
}
