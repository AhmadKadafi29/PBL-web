<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
{
    $users = User::where('role', 'karyawan')->get();

    // Sembunyikan kolom-kolom tertentu dari setiap objek pengguna
    $users->makeHidden([
        'email_verified_at',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
        'created_at',
        'updated_at'
    ]);

    return response()->json([
        'message' => 'data user',
        'user' => $users
    ]);
}


    public function store(StoreUserRequest $request)
    {
        $user = new User;
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'role' => 'required|in:karyawan',
            'password'=>'required',
            'alamat' => 'required',
            'no_telp'=> 'required'
        ];

        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json([
                'message'=>'Gagal memasukkan data ',
                'data'=> $validator->errors()
            ]);
        }

        $user->name= $request->name;
        $user->email= $request->email;
        $user->roles= $request->roles;
        $user->password= Hash::make($request->password);
        $user->alamat= $request->alamat;
        $user->no_telp= $request->no_telp;
        $post = $user->save();

        return response()->json([
            "message" => "Data berhasil Ditambahkan",
        ], 200);
    }



   // In your UserController.php file
public function update(Request $request, $id)
{
    $user = User::find($id);
    $validatedData = $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'role' => 'required|in:karyawan',
        'password' => 'required',
        'alamat' => 'required',
        'no_telp' => 'required'
    ]);

    // Handle password hashing if needed
    if ($request->has('password')) {
        $validatedData['password'] = Hash::make($validatedData['password']);
    }

    $user->update($validatedData);

    return response()->json([
        'message' => 'User updated successfully',
        'user' => $user
    ], 200);
}


    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
       $user = User::find($id);
       $post= $user->delete();
        return response()->json([
            'message' => 'Delete Succes'
        ]);
    }
}
