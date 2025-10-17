<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);


        // Default role: Petugas (fallback jika belum ada)
        $role = Role::firstWhere('name', 'Petugas');


        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $role ? $role->id : null, // pastikan sudah ada seeder roles
        ]);


        // login otomatis setelah register
        auth()->login($user);


        // redirect sesuai role (kemungkinan Petugas)
        if ($user->role && $user->role->name === 'Admin') {
            return redirect()->route('admin.dashboard');
        }


        return redirect()->route('petugas.dashboard');
    }
}


