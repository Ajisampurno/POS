<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Passport\Passport;

class AuthController extends Controller
{
    public function index()
    {
        $data = User::all();
        return $data;
    }

    public function login(Request $request)
    {
        $email = request('email');
        $password = request('password');
        $user = User::where('email', $email)->first();
        if (!$user) {
            return $this->response(false, null, "User Not Found");
        }
        $requestpass = Hash::make($password);
        if (!Hash::check($request->password, $user->password)) {
            return $this->response(false, null, "Wrong Password");
        }


        // if(!Auth::check($data)){
        //     return $this->response(false,null,"Login Gagal Cuy");
        // }
        // $user=Auth::user();
        $token = $user->createToken('API Token')->accessToken;
        return response()->json([
            'access_token' => $token,
            'user' => $user
        ]);
    }


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Buat token otentikasi untuk user yang terdaftar
        $token = $user->createToken('auth_token')->plainTextToken;

        // Kembalikan response dengan token
        return response()->json(['token' => $token], 201);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return response()->json(['message' => 'Logout successful']);
    }
}
