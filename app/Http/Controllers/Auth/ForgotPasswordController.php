<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;


class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('auth.forgot_password');
    }


    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);


        $user = User::where('email', $request->email)->firstOrFail();


        // buat token random (kirim token mentah via email) dan simpan hash di DB
        $token = Str::random(64);
        $tokenHash = Hash::make($token);


        // invalidate token lama untuk user ini
        PasswordReset::where('user_id', $user->id)->update(['used' => true]);


        // simpan token baru
        PasswordReset::create([
            'user_id' => $user->id,
            'token_hash' => $tokenHash,
            'expires_at' => Carbon::now()->addMinutes(60),
            'used' => false,
        ]);


        // kirim email (simple). Pastikan konfigurasi MAIL_ di .env
        $resetLink = url("/reset-password/{$token}");
        Mail::raw("Klik link berikut untuk reset password: {$resetLink}", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Reset Password Akun Anda');
        });


        return back()->with('status', 'Link reset password telah dikirim ke email Anda. Cek inbox atau spam.');
    }
}
