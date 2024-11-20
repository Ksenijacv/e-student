<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    /**
     * Registracija novog korisnika.
     */
    public function register(Request $request)
    {
        // Validacija unosa
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'tip_korisnika' => 'required|in:profesor,ucenik,roditelj',
            
        ]);

        // Kreiranje korisnika
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tip_korisnika' => $request->tip_korisnika,
        ]);

        // Generisanje tokena
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Korisnik uspešno registrovan.',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    /**
     * Logovanje korisnika.
     */
    public function login(Request $request)
    {
        // Validacija unosa
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Provera kredencijala
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['Uneli ste neispravne podatke.'],
            ]);
        }

        // Ulogovani korisnik
        $user = Auth::user();

        // Generisanje tokena
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Uspešno ste se prijavili.',
            'user' => $user,
            'token' => $token,
        ]);
    }

    /**
     * Izlogovanje korisnika.
     */
    public function logout(Request $request)
    {
        // Brisanje tokena za trenutnog korisnika
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Uspešno ste se odjavili.',
        ]);
    }
}
