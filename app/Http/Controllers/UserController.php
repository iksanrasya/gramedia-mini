<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi data
        $validateData = $request->validate([
            // 'name_input' => ['jenis_validasi']
            // required = datanya harus diisi
            'name' => ['required', 'min:3'],
            // unique : email gabole duplikat : users,email = dari table users field email
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'max:10'],
        ]);

        // simpan data ke model user
        User::create([
            // 'nama_field' => $isianData
            'name' => $validateData['name'],
            'email' => $validateData['email'],
            // hasting : ubah plain text menjadi karakter acak,digunakan pada data yang difat nya rahasia
            'password' => Hash::make($validateData['password']),
            'role' => 'user',
        ]);

        // setelah data dibuat halaman akan di arahkan kemana
        // with('nama')
        return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
    }

    public function login(Request $request)
    {
        // validasi data
        $validateData = $request->validate([
            // 'name_input' => ['jenis_validasi']
            // required = datanya harus diisi
            'email' => ['required'],
            'password' => ['required'],
        ]);

        // Auth::atempt() : memerlukan data username/email dan pw yang uda di hashing,
        // yang dilakukan nya
        // 1. cek pw yang di hashing apakah sama kaya pw text yang di input
        // 2. mencocokan username/email dan pw tsb
        // 3. kalau cocok data penggunanya disimpan di session/cookies web

        $data = [
            'email' => $validateData['email'],
            'password' => $validateData['password'],
        ];

        if (Auth::attempt($data)) {
            // register idsession afer login berhasil
            $request->session()->regenerate();

            // Auth::user() : mengabil data user yang sedang login
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Login berhasil');
            } else {
                // jika berhasil login, maka akan diarahkan kemana
                return redirect()->route('home')->with('success', 'Login berhasil');
            }
        } else {
            // jika gagal login, diarahkan kemana
            return redirect()->route('login')->with('error', 'Email atau password salah.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Logout berhasil');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
