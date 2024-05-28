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
        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'role' => $request['role'],
            'alamat' => $request['alamat'],
            'no_telp' => $request['no_telp']
            // 'phone'=>$request['phone'],
            // 'address'=>$request['address']
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
        $user = User::find($id);
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),
            'alamat' => $request->input('alamat'),
            'no_telp' => $request->input('no_telp')
        ]);

        return redirect()->route('user.index')->with('success', 'User updated successfully');
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
