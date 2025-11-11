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
    /**
     * Tampilkan halaman form lupa password
     */
    public function index()
    {
        return view('auth.forgot_password');
    }

    /**
     * Kirim link reset password ke email user
     */
    public function sendResetLink(Request $request)
    {
        // Validasi input email
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Email tidak ditemukan dalam sistem.',
        ]);

        // Ambil data user
        $user = User::where('email', $request->email)->firstOrFail();

        // Buat token baru (token mentah dikirim via email)
        $token = Str::random(64);
        $tokenHash = Hash::make($token);

        // Tandai semua token lama milik user ini sebagai "used"
        PasswordReset::where('user_id', $user->id)->update(['used' => true]);

        // Simpan token baru
        PasswordReset::create([
            'user_id' => $user->id,
            'token_hash' => $tokenHash,
            'expires_at' => Carbon::now()->addMinutes(60),
            'used' => false,
        ]);

        // Buat URL reset password
        $resetLink = url("/reset-password/{$token}");

        // Kirim email ke user
        Mail::raw("Klik link berikut untuk reset password Anda: {$resetLink}", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Reset Password Akun Anda');
        });

        // Kembali ke halaman form dengan notifikasi sukses
        return back()->with('status', 'Link reset password telah dikirim ke email Anda. Silakan cek inbox atau folder spam.');
    }
}
