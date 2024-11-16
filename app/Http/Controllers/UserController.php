<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = DB::table('users')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->select('id', 'name', 'email', 'role', 'alamat', 'no_telp')
            ->paginate(10);
        return view('pages.user.index', compact('users'));
    }


    public function create()
    {
        return view('pages.user.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:5|max:30',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|max:16',
            'role' => 'required',
            'alamat' => 'required|min:5|max:255',
            'no_telp' => 'required|min:11|max:12',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.min' => 'Nama harus memiliki minimal 5 karakter.',
            'name.max' => 'Nama tidak boleh lebih dari 30 karakter.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',

            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password harus memiliki minimal 8 karakter.',
            'password.max' => 'Password tidak boleh lebih dari 16 karakter.',

            'role.required' => 'Role wajib dipilih.',

            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.min' => 'Alamat harus memiliki minimal 5 karakter.',
            'alamat.max' => 'Alamat tidak boleh lebih dari 255 karakter.',

            'no_telp.required' => 'Nomor telepon wajib diisi.',
            'no_telp.min' => 'Nomor telepon harus memiliki minimal 11 digit.',
            'no_telp.max' => 'Nomor telepon tidak boleh lebih dari 12 digit.',
        ]);


        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('role'),
            'alamat' => $request->input('alamat'),
            'no_telp' => $request->input('no_telp')
        ]);

        return redirect()->route('user.index')->with('success', 'User baru berhasil ditambahkan');
    }


    public function edit(User $user)
    {
        return view('pages.user.edit')->with('user', $user);
    }
    /**
     * Display the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:5',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required',
            'alamat' => 'required|min:5',
            'no_telp' => 'required|min:11',
        ], [
            'name.min' => 'Nama harus memiliki minimal 5 karakter.',
            'email.unique' => 'Email sudah terdaftar.',
            'alamat.min' => 'Alamat harus memiliki minimal 5 karakter.',
            'no_telp.min' => 'Nomor telepon harus memiliki minimal 11 digit.',
        ]);

        $user = User::find($id);
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),
            'alamat' => $request->input('alamat'),
            'no_telp' => $request->input('no_telp')
        ]);

        return redirect()->route('user.index')->with('success', 'User berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('user.index')->with('success', 'user berhasil dihapus');
    }
}
