<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


class ResetPasswordController extends Controller
{
    public function index($token)
    {
        return view('auth.reset_password', compact('token'));
    }


    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);


        // ambil semua token aktif (belum used dan belum expired)
        $resets = PasswordReset::where('used', false)
            ->where('expires_at', '>', Carbon::now())
            ->get();


        $found = null;
        foreach ($resets as $reset) {
            if (Hash::check($request->token, $reset->token_hash)) {
                $found = $reset;
                break;
            }
        }


        if (!$found) {
            return back()->withErrors(['token' => 'Token tidak valid atau sudah kadaluarsa.']);
        }


        // update password user
        $user = $found->user;
        $user->password = Hash::make($request->password);
        $user->password_changed_at = now();
        $user->save();


        // tandai token sudah dipakai
        $found->used = true;
        $found->save();


        return redirect()->route('login')->with('status', 'Password berhasil diubah. Silakan login dengan password baru.');
    }
}
