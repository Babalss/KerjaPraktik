<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }


    public function authenticate(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        $remember = $request->boolean('remember');


        if (Auth::attempt($data, $remember)) {
            $request->session()->regenerate();


            $user = Auth::user();


            // Redirect sesuai role
            if ($user->role && $user->role->name === 'Admin') {
                return redirect()->route('admin.dashboard');
            }


            if ($user->role && $user->role->name === 'Petugas') {
                return redirect()->route('petugas.dashboard');
            }


            // fallback
            return redirect()->intended('/');
        }


        return back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->onlyInput('email');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();


        return redirect()->route('login');
    }
}
